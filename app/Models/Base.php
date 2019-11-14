<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Uuid;

abstract class Base extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $primaryKey = 'id';

    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->id = self::generateUuid();
        });
    }

    public static function generateUuid()
    {
         return Uuid::generate();
    }
}
