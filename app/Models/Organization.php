<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    public function traffic()
    {
        return $this->belongsTo(Traffic::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
