<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Auth;
use Uuid;

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

        $products = Product::join('favorites','products.id','favorites.product_id')
            ->orderBy('favorites.updated_at','DESC')
            ->where('favorites.user_id', getUserId())
            ->where('products.enabled', true)
            ->select('products.*');

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
    public function doFavorite(Request $request,$locale, $id)
    {
        $faverited = $request->is_fav;
        $user = Auth::user();
        if($faverited){
            $user->favorites()->attach($id,["id" => Uuid::generate()]);
        }else{
            $user->favorites()->detach($id);
        }

        return response()->json([]);
    }
}
