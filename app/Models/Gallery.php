<?php

namespace App\Models;

class Gallery extends Base
{
    
    protected $table = 'galleries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='galleries';
    protected $fillable = [
        'name',
        'is_cover',
        'product_id',
        'is_lock',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    //Make it available in the json response
    protected $appends = ['photo_url'];

    /**
     * Get photo_url attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if($this->name){
            return getUrlStorage($this->name);
        }
        return '';
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }

}
