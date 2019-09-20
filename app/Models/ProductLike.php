<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLike extends Base
{
    protected $table = 'product_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='post_media';
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
