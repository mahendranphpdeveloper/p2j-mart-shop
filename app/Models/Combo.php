<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'product_ids', 'total_price', 'offer_price', 'description', 'status'];
    protected $casts = [
        'product_ids' => 'array', 
    ];
    public function products()
    {
        return Product::whereIn('id', $this->product_ids)->get();
    }
}
