<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Uuid;
use App\Notifications\ResetPassword;

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
        'slug',
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

    //Make it available in the json response
    protected $appends = ['photo_url'];

    /**
     * Get photo_url attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if($_photo = $this->cphoto){
            return getUrlStorage('profiles/'.$_photo);
        }
        return asset('images/profile.jpg');
    }

    public function user_contact()
    {
        return $this->hasOne(UserContact::class,'user_id');
    }

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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
