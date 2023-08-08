<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sity;

class Area extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['check'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function ($builder) {
            $builder->where('status', true);
        });
    }

    public function region()
    {
        return $this->belongsTo(Sity::class, 'city_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function getCheckAttribute()
    {

        if (auth()->check()) {
            $user = auth()->user();

            if ($areas = $user->areas) {

                $areasArr = explode(',', $areas);
                if (in_array($this->id, $areasArr)) {
                    return true;
                }

                return false;
            }

            return true;
        }

        return false;
    }
}