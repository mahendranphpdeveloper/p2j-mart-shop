<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductImage;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_unit_id',
        'session_id',
        'product_id',
    ];

    /**
     * Relationship: Wishlist belongs to a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Optional: To get product image through the product relationship.
     */
    public function productImage()
    {
        return $this->hasOneThrough(ProductImage::class, Product::class, 'product_id', 'product_id', 'product_id', 'product_id');
    }
    
 public function productUnit()
    {
        return $this->hasOneThrough(
            ProductUnit::class,
            Product::class,
            'product_id', // Foreign key on products table
            'product_id', // Foreign key on product_units table
            'product_id', // Local key on wishlists table
            'product_id'  // Local key on products table
        );
    }

    /**
     * Relationship: Wishlist belongs to a ProductUnit.
     */
    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'product_unit_id');
    }
}
