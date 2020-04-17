<?php

namespace App\Models;

class Chat extends Base
{
    protected $table = 'chat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='chat';
    protected $fillable = [
        'post_id',
        'from_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];

}
