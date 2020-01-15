<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\User;
use App\Models\UserContact;
use Image;
use File;
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = getUserId();
        $search_name = $request->search_name; //search user type 
        $sub = $request->sub;
        $cat = $request->cat;
        
        $page = $request->input('page', 1);
        $per_page = $this->per_page;

        $data = Product::orderBy('created_at','DESC')
            ->select('products.*')
            ->join('sub_categories','sub_categories.id','products.sub_category_id')
            ->where('products.user_id', $user_id);

        if ($search_name) {
            $_like = setLike($search_name);
            $data->where('products.name', 'LIKE', $_like);
        }

        if ($cat) {
            $data->where('sub_categories.category_id', $cat);
        }

        if ($sub) {
            $data->where('products.sub_category_id', $sub);
        }

        $data->where('products.enabled',true);
        
        $data = $data->paginate($per_page);

        $_data = compact('data','page', 'search_name','sub','cat');

        return view('products.index',$_data)
            ->with('i', ($page - 1) * $per_page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $userContact = UserContact::find(getUserId());
      if(empty($userContact)){
        return redirect()->route('profile.contact',getLang())
                         ->with('warning','Please to complete your profile!');
      }
        if(!checkForPost()){
          return redirect()->route('products.index',getLang())
                         ->with('warning','You cannot post more product!');
        }
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!checkForPost()){
          return redirect()->route('products.index',getLang())
                         ->with('warning',__('You cannot post more product!'));
        }

        $user_id = getUserId();
        $request['user_id'] = $user_id;
        $input = $request->all();
        $_rules = [
          'sub_category_id.required' => 'The category field is required.'
        ];
        $_name_unique = [
          'required',
          'unique:products,name,null,id,enabled,1,user_id,'.$user_id
        ];
        $this->validate($request, [
            'name'  => $_name_unique,
            'sub_category_id' => 'required',
            'cover' => 'required',
            'photos' => 'required',
            'description' => 'required',
        ],$_rules);

        DB::beginTransaction();
        $cover = '';
        if(isset($input['cover'])){
          $cover = $input['cover'];
        }
        $input['slug'] = custom_slug($input['name']) .'-'. $user_id;
        $product = Product::create($input);                   
        if($product){
            
            $_photos = [];
            if(isset($input['photos'])){
              $_photos = $input['photos'];
            }

            if($_photos){
              $_excepts = [];
              $_limit_upload = getLimitUpload();
                $_id = $product->id;
                $_incr = 0;
                foreach($_photos as $_photo){
                  if($_incr >= $_limit_upload){
                    $_excepts[] = $_photo['name'];
                    continue;
                  }
                  $_photo['product_id'] = $_id;
                  $_suc = Gallery::create($_photo);
                  if($_suc){
                    try{
                      $_name = $_photo['name'];
                      $_src = "tmp/$_name";
                      $_dest = "products/$_name";
                      
                      $_image = file_get_contents(getPublicPathStorage($_src));
                      getDisk()->put($_dest, $_image,'public');
                    }catch(Exception $err){
                      DB::rollBack();
                      return redirect()->route('products.index',getLang())->with('error','Your data cannot save!');  
                    }
                  }else{
                    DB::rollBack();
                    return redirect()->route('products.index',getLang())->with('error','Your data cannot save!');
                  }
                  $_incr++;
                }

                foreach($_excepts as $_name){
                  getPublicDisk()->delete("tmp/$_name");
                }

                if(empty($cover) || in_array($cover, $_excepts)){
                  $cover = $_photos[0]['name'];
                }

                $_gallery = Gallery::where('product_id',$product->id)->where('name',$cover)->first();
                if(!empty($_gallery)){
                  $_gallery->update(['is_cover'=>true]);
                }
            }
            
            DB::commit();
        }

        return redirect()->route('products.index',getLang())
                         ->with('message','Product has created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$locale,$id)
    {
        $page = $request->input('page',1);
        $user_id = getUserId();
        $data = Product::where('id',$id)
            ->where('user_id',$user_id)
            ->where('enabled',true)
            ->first();

        if(empty($data)){
            return back()->with('message','This product is not found');
        }

        return view('products.edit',compact('data','page'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$locale, $id)
    {
        $user_id = getUserId();
        $request['user_id'] = $user_id;
        $input = $request->all();

        $_name_unique = [
          'required',
          "unique:products,name,$id,id,enabled,1,user_id,$user_id"
        ];
        $_rules = [
          'sub_category_id.required' => 'The category field is required.'
        ];

        $this->validate($request, [
            'name'  => $_name_unique,
            'sub_category_id' => 'required',
            'cover' => 'required',
            'photos' => 'required',
            'description' => 'required',
        ],$_rules);
        
        DB::beginTransaction();
        $cover = $input['cover'];
        $data = Product::where('id',$id)
            ->where('user_id',$user_id)
            ->where('enabled',true)
            ->first();
        $db_name = $data->name;
        $files = $data->galleries;

        if($db_name != $input['name']){
          $input['slug'] = custom_slug($input['name']) .'-'. $user_id;
        }
        $product = $data->update($input);
        if($product){
            $obj_cover = null;
            $_photos = [];
            if(isset($input['photos'])){
              $_photos = $input['photos'];
            }

            if($_photos){
              $_excepts = [];
              $_limit_upload = getLimitUpload();
                $_tmp_photos = [];
                $_incr = 0;
                foreach($_photos as $_photo){
                  $_name = $_photo['name'];
                  if($_incr >= $_limit_upload){
                    $_excepts[] = $_name;
                    continue;
                  }

                  $_tmp_photos[] = $_name;
                  $_is_new = true;
                  //todo check the name is new
                  foreach($files as $entity){
                    if($entity->name == $_name){
                      $_is_new = false;
                      break;
                    }
                  }
                  if($_is_new){
                    $_photo['product_id'] = $id;
                    $_suc = Gallery::create($_photo);
                    if($_suc){
                      try{
                        $_src = "tmp/$_name";
                        $_dest = "products/$_name";
                        
                        $_image = file_get_contents(getPublicPathStorage($_src));
                        getDisk()->put($_dest, $_image,'public');
                      }catch(Exception $err){
                        DB::rollBack();
                        return redirect()->route('products.index',getLang())->with('error','Your data cannot save!');  
                      }
                    }else{
                      DB::rollBack();
                      return redirect()->route('products.index',getLang())->with('error','Your data cannot save!');
                    }
                  }
                }

                foreach($files as $entity){
                  if($entity->is_cover){
                    $obj_cover = $entity;
                  }
                  if(!in_array($entity->name,$_tmp_photos)){
                    $_name = $entity->name;
                    getDisk()->delete("products/$_name");
                    $entity->delete();
                  }
                }

                if($obj_cover){
                  $obj_cover->update(['is_cover'=>false]);
                }

                if( in_array($cover, $_excepts) ){
                  $cover = $_photos[0]['name'];
                }

                $_gallery = Gallery::where('product_id',$id)->where('name',$cover)->first();
                if(!empty($_gallery)){
                  $_gallery->update(['is_cover'=>true]);
                }
            }

            DB::commit();
        }
        $page = $request->input('page',1);
        return redirect()->route('products.index',['page'=>$page,'locale'=>getLang()])
                        ->with('message','Product has updated successfully');
    }

    public function destroy(Request $request,$locale, $id)
    {
        $page = $request->input('page',1);
        Product::find($id)->update(['enabled'=>0]);

        return redirect()->route('products.index',['page'=>$page,'locale'=>getLang()])
                ->with('message','Product has deleted successfully');
    }
  
}

