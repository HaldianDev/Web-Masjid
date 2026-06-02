<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZisRecord extends Model
{
    protected $fillable = [
        'type',
        'person_type',
        'name',
        'phone',
        'address',
        'amount_money',
        'amount_rice',
        'date_recorded',
        'notes',
    ];

    protected $casts = [
        'date_recorded' => 'date',
        'amount_money' => 'decimal:2',
        'amount_rice' => 'decimal:2',
    ];
}
