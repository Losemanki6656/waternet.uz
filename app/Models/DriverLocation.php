<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    protected $fillable = [
        'user_id',
        'organization_id',
        'latitude',
        'longitude',
        'accuracy',
        'speed',
        'heading',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
