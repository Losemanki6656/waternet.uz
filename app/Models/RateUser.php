<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateUser extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function success_order()
    {
        return $this->belongsTo(SuccessOrders::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
