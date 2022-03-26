<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeProduct extends Model
{
    use HasFactory;

    public function received()
    {
        return $this->belongsTo(User::class,'received_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


    public function sent()
    {
        return $this->belongsTo(User::class,'sent_id');
    }

}
