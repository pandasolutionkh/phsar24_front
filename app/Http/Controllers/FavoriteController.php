<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Auth;

class FavoriteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');   
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $per_page = $this->per_page;

        $products = Favorite::select('favorites.*')
            ->orderBy('favorites.updated_at','DESC')
            ->join('products','products.id','favorites.product_id')
            ->where('favorites.user_id', getUserId())
            ->where('products.enabled', true);

        $products = $products->paginate($per_page);

        return view('favorites.index',compact('products','page'))
            ->with('i', ($page - 1) * $per_page);
    }

    /**
     * DeleteFavorite a particular post
     *
     * @param  Product $product
     * @return Response
     */
    public function deleteFavorite(Product $product)
    {
        $res = [
            'result' => 'error'
        ];
        if($product){
            $res['result'] = 'ok';
            Auth::user()->favorites()->detach($product->id);
        }

        return response()->json($res);
    }
    
    /**
     * Favorite a particular product
     *
     * @param  Request $request
     * @return Response
     */
    public function doFavorite(Request $request, $id)
    {
        $faverited = $request->is_fav;
        if($faverited){
            Auth::user()->favorites()->detach($id);   
        }else{
            Auth::user()->favorites()->attach($id);
        }

        return back();
    }
}
