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
    public function index(Request $request,$slug)
    {
      $search = $request->input('s');
      $product_per_page = 15;
      $products = Product::orderBy('updated_at','DESC')
            ->select('products.*')
            ->join('sub_categories','sub_categories.id','products.sub_category_id')
            ->join('categories','categories.id','sub_categories.category_id')
            ->where('products.enabled',true)
            ->where('categories.slug', $slug);

      if ($search) {
        $_search = setLike($search);
        $products->where(function($q) use($_search){
            $q->where('products.name', 'LIKE', $_search)
                ->orWhere('products.description', 'LIKE', $_search);
        });
      }

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

      $sub_categories = SubCategory::select('sub_categories.*')
        ->join('categories','categories.id','sub_categories.category_id')
        ->where('sub_categories.enabled',true)
        ->where('categories.slug',$slug)
        ->get();

      $category = Category::where('slug',$slug)->first();

      $page = $request->input('p', 1);
      $products = $products->paginate($product_per_page);

      $category_slug = $slug;

      return view('categories.index',compact('products','page','sub_categories','category_slug','category','search'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sub(Request $request,$category_slug,$sub_category_slug)
    {
      $search = $request->input('s');
      $product_per_page = 15;
      
      $products = Product::orderBy('updated_at','DESC')
            ->select('products.*')
            ->join('sub_categories','sub_categories.id','products.sub_category_id')
            ->join('categories','categories.id','sub_categories.category_id')
            ->where('products.enabled',true)
            ->where('categories.slug', $category_slug)
            ->where('sub_categories.slug', $sub_category_slug);


      if ($search) {
        $_search = setLike($search);
        $products->where(function($q) use($_search){
            $q->where('products.name', 'LIKE', $_search)
                ->orWhere('products.description', 'LIKE', $_search);
        });
      }

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

      $sub_categories = SubCategory::select('sub_categories.*')
        ->join('categories','categories.id','sub_categories.category_id')
        ->where('sub_categories.enabled',true)
        ->where('categories.slug',$category_slug)
        ->get();

      $category = SubCategory::where('slug',$sub_category_slug)->first();

      $page = $request->input('p', 1);
      $products = $products->paginate($product_per_page);

      return view('categories.sub',compact('products','page','sub_categories','category_slug','category','sub_category_slug','search'));
    }

}
