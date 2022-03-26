<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sity;

class Area extends Model
{
    use HasFactory;

    public function region()
    {
        return $this->belongsTo(Sity::class,'city_id');
    }

}
