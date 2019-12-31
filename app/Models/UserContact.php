<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = 'user_contacts';
    
    public $primaryKey = 'user_id';
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
    // protected $table ='user_contacts';
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'address',
        'province_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
