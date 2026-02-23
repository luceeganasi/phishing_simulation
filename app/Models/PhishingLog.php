<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhishingLog extends Model
{
    protected $fillable = [
        'session_id',
        'email',
        'ip_address',
        'latitude',
        'longitude',
        'location_label',
        'user_agent',
        'captured_at',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
        'latitude'    => 'float',
        'longitude'   => 'float',
    ];
}
