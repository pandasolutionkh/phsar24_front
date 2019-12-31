<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Uuid;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'phone', 
        'email', 
        'password',
        'enabled',
        'is_activated',
        'is_unlimited',
        'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'enabled',
    ];

    public function userActivate()
    {
        return $this->hasOne(UserActivate::class,'user_id');
    }

    /**
     * Get all of favorite products for the user.
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'user_id', 'product_id')->withTimeStamps();
    }

    /**
     * Get all of likes products for the user.
     */
    public function postLikes()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'user_id', 'product_id')->withTimeStamps();
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = self::generateUuid();
         });
    }

    public static function generateUuid()
    {
         return Uuid::generate();
    }
}
