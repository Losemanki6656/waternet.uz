<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsText extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'sms_text',
        'full_sms_text'
    ];
}
