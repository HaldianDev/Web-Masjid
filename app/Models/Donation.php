<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_name',
        'donor_phone',
        'amount',
        'payment_method',
        'status',
        'reference_id',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
