<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qurban extends Model
{
    protected $fillable = [
        'year',
        'participant_name',
        'phone',
        'type',
        'group_number',
        'amount_paid',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
    ];
}
