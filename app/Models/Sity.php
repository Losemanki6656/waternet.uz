<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function clients()
    {
        return $this->hasMany(Client::class,'city_id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class,'city_id');
    }
}
