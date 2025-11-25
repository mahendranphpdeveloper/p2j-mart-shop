<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'base_weight',
        'base_cost',
        'additional_weight_unit',
        'additional_cost_per_unit'
    ];
}

