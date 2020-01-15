<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Base
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $table ='products';
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'price',
        'promotion',
        'sub_category_id',
        'slug',
        'enabled'
    ];

    public function liked()
    {
        return (bool) ProductLike::where('user_id', Auth::id())
                            ->where('product_id', $this->id)
                            ->first();
    }

    public function favorited()
    {
        return (bool) Favorite::where('user_id', Auth::id())
                            ->where('product_id', $this->id)
                            ->first();
    }

    function sub_category(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class,'product_id');
    }

    public function product_likes()
    {
        return $this->hasMany(ProductLike::class,'product_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
