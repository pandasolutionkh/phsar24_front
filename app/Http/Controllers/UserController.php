<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\SubCategory;

class UserController extends Controller
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
    public function index(Request $request,$locale,$slug)
    {
      $product_per_page = 15;
      
      $products = Product::orderBy('products.updated_at','DESC')
        ->select('products.*')
        ->join('users','products.user_id','users.id')
        ->where('products.enabled',true)
        ->where('users.slug',$slug);

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

      $page = $request->input('p', 1);
      $products = $products->paginate($product_per_page);
      $user = User::where('slug',$slug)->first();

      return view('users.index',compact('products','page','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request,$locale,$slug)
    {
      $user = User::where('slug',$slug)->first();
      return view('users.contact',compact('user'));
    }

}
