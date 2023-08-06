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

    public function scopeFilter()
    {
        return self::query()
            ->whereHas('client', function ($q) {
                $q->where('organization_id', auth()->user()->organization_id);
            })
            ->when(request('search'), function ($query, $search) {
                $query->whereHas('client', function ($q) use ($search) {
                    $q->where('fullname', 'LIKE', '%' . $search . '%');
                })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    });
            })
            ->when(request('data'), function ($query, $data) {
                return $query->whereDate('created_at', $data);
            })
            ->where('status', true);
    }
}