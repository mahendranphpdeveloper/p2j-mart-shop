<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductImage;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts'; // Specify the correct table name

    protected $fillable = [
        'user_id', 'product_id',product_unit_id 'quantity', 'price', 'session_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function productImage()
    {
        return $this->hasOneThrough(ProductImage::class, Product::class);
    }
        public function productUnit()
        {
            return $this->belongsTo(Productunit::class, 'product_unit_id', 'product_unit_id');
        }
}