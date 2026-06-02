<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'item_name',
        'code',
        'quantity',
        'condition',
        'location',
        'purchase_date',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];
}
