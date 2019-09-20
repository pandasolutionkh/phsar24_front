<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivate extends Model
{
    protected $table = 'user_activates';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    // protected $table ='user_activates';
    protected $fillable = [
        'user_id',
        'token'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
