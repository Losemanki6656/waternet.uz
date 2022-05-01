<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function suc_or()
    {
        return $this->hasMany(SuccessOrder::class);
    }

}
