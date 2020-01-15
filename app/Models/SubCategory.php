<?php

namespace App\Models;

class SubCategory extends Base
{
    protected $table = 'sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='sub_categories';
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'slug',
        'enabled'
    ];

    function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
