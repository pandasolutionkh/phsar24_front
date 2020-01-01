<?php

namespace App\Models;

class Province extends Base
{
    protected $table = 'provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='provinces';
    protected $fillable = [
        'name',
        'country_id',
        'description',
        'enabled'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

}
