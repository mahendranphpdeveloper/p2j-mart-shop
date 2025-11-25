<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedItem extends Model
{
    use HasFactory;

    protected $table = 'stock_reservations';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_unit_id',
        'qty',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}

