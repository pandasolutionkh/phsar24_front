<?php

namespace App\Models;

class Favorite extends Base
{
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='favorites';
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
