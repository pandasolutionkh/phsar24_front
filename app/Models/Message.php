<?php

namespace App\Models;

class Message extends Base
{
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='countries';
    protected $fillable = [
        'from_id',
        'to_id',
        'message',
        'read'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];

}
