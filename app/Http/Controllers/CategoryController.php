<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
      $product_per_page = 15;
      $products = Product::orderBy('updated_at','DESC')
            ->select('products.*')
            ->join('sub_categories','sub_categories.id','products.sub_category_id')
            ->where('products.enabled',true)
            ->where('sub_categories.category_id', $id);

      if($request->ajax()){
            $page = $request->input('page', 1);

            $products = $products->paginate($product_per_page);
            
            $last_page = $products->lastPage();
            $total = ceil($products->total() / $product_per_page);

            $html = '';
            foreach ($products as $data) {
              $html .= view('products.item',compact('data','page'))->render();
            }

            if($html == ''){
              $page = $last_page;
            }
            
            $res = compact('html','page', 'total');
            return response()->json($res);
      }

      $sub_categories = SubCategory::where('category_id',$id)
        ->where('enabled',true)
        ->get();

      $category = Category::find($id);

      $page = $request->input('p', 1);
      $products = $products->paginate($product_per_page);

      $category_id = $id;

      return view('categories.index',compact('products','page','sub_categories','category_id','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sub(Request $request,$id,$sid)
    {
      $product_per_page = 15;
      
      $products = Product::orderBy('updated_at','DESC')
            ->select('products.*')
            ->join('sub_categories','sub_categories.id','products.sub_category_id')
            ->where('products.enabled',true)
            ->where('sub_categories.category_id', $id)
            ->where('sub_categories.id', $sid);

      if($request->ajax()){
            $page = $request->input('page', 1);

            $products = $products->paginate($product_per_page);
            
            $last_page = $products->lastPage();
            $total = ceil($products->total() / $product_per_page);

            $html = '';
            foreach ($products as $data) {
              $html .= view('products.item',compact('data','page'))->render();
            }

            if($html == ''){
              $page = $last_page;
            }
            
            $res = compact('html','page', 'total');
            return response()->json($res);
      }

      $sub_categories = SubCategory::where('category_id',$id)
        ->where('enabled',true)
        ->get();

      $category = SubCategory::find($sid);

      $page = $request->input('p', 1);
      $products = $products->paginate($product_per_page);

      $category_id = $id;
      $sub_category_id = $sid;

      return view('categories.index',compact('products','page','sub_categories','category_id','category','sub_category_id'));
    }

}
