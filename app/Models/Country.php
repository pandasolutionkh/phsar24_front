<?php

namespace App\Models;

class Country extends Base
{
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='countries';
    protected $fillable = [
        'name',
        'description',
        'enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];

}
