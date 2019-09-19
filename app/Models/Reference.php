<?php

namespace App\Models;

class Reference extends Base
{
    
    protected $table = 'references';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='references';
    protected $fillable = [
        'name',
        'link',
        'photo',
       	'description',
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
