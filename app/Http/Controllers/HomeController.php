<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class HomeController extends Controller
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
    public function index(Request $request)
    {
        $product_per_page = 25;
        
        if($request->ajax()){
            $page = $request->input('page', 1);

            $products = Product::where('enabled',true)->orderBy('updated_at','DESC');
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
        }else{
            $page = $request->input('p', 1);
            $product_per_page = ($product_per_page * $page);
            $sliders = Banner::where('enabled',true)->where('is_activated',true)->get();
            $products = Product::where('enabled',true)->orderBy('updated_at','DESC');
            $products = $products->paginate($product_per_page);

            return view('home',compact('sliders','products','page'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function product(Request $request,$id)
    {
        $data = Product::find($id);
        if(empty($data)){
            $res['form'] = "Your data is not correct!";
            return response()->json($res);
        }

        $res['form'] = view('products.detail',compact('data'))->render();
        
        return response()->json($res);
        
    }

}
