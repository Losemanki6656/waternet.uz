<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficOrganization extends Model
{
    use HasFactory;

    public function traffic()
    {
        return $this->belongsTo(Traffic::class);
    }
}
