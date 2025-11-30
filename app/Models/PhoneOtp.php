<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneOtp extends Model
{
    protected $fillable = [
        'phone', 'otp', 'expires_at'
    ];

    protected $dates = ['expires_at'];
}
