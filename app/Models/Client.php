<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sity;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'city_id',
        'area_id',
        'fullname',
        'street',
        'home_number',
        'entrance',
        'floor',
        'apartment_number',
        'address',
        'location',
        'login',
        'password',
        'balance',
        'container',
        'bonus',
        'phone',
        'phone2',
        'activated_at'
    ];
  

    protected $dates = ['active'];

    public function city()
    {
        return $this->belongsTo(Sity::class,'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
