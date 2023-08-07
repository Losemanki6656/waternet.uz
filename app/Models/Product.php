<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function ($builder) {
            $builder->where('status', true);
        });
    }
}