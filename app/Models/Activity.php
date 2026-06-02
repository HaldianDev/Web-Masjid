<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'event_date',
        'event_time',
        'speaker',
        'location',
        'image_path',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}
