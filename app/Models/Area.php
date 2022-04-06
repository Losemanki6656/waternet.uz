<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sity;

class Area extends Model
{
    use HasFactory;

    protected $appends = ['check'];

    public function region()
    {
        return $this->belongsTo(Sity::class,'city_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function getCheckAttribute()
    {

        if (auth()->check()) {
            $user = auth()->user();
            
            if ($region_user = $user->regionUser) {
                
                $areas = explode(',', $region_user->areas);
                if (in_array($this->id, $areas)) {
                    return true;
                }

                return false;
            }
            
            return true;
        }

        return false;
    }
}
