<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FridaySchedule extends Model
{
    protected $fillable = [
        'date',
        'imam',
        'khotib',
        'muadzin',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
