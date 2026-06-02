<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerSchedule extends Model
{
    protected $fillable = [
        'city',
        'date',
        'imsak',
        'subuh',
        'syuruk',
        'dzuhur',
        'ashar',
        'maghrib',
        'isya',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
