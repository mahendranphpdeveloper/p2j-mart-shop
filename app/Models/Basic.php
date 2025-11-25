<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basic extends Model
{
    use HasFactory;

    protected $table = 'basic'; // explicitly mention if table name is not plural

    protected $fillable = [
        'name',
        'brand',
        'quantity',
        'warranty',
        'return_policy',
        'delivery_mode',
        'status',
        'display_order',
    ];
}
