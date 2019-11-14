<?php

namespace App\Models;

class Master extends Base
{
    protected $table = 'masters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    
    // protected $table ='masters';
    protected $fillable = [
        'title',
        'description',
        'photo',
        'is_activated',
        'enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'enabled'
    ];
}



