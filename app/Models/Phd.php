<?php

namespace App\Models;

class Phd extends Base
{
    protected $table = 'phd';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    
    // protected $table ='phd';
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



