<?php

namespace App\Models;

class Category extends Base
{
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='categories';
    protected $fillable = [
        'name',
       	'description',
        'enabled'
    ];

    protected $sortable = [
        'name',
    ];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class,'category_id')->where('enabled',true);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
