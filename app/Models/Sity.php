<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sity extends Model
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

    public function clients()
    {
        return $this->hasMany(Client::class, 'city_id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'city_id');
    }
}