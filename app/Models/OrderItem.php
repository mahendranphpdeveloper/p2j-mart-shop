<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_unit_id',
        'quantity',
        'price',
    ];

    // Define relationships
    public function order()
    {
        return $this->belongsTo(UserOrder::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productUnit()
    {
        return $this->belongsTo(Productunit::class, 'product_unit_id', 'product_unit_id');
    }

    /**
     * Get the related product image for this order item (used for e.g., thumbnails in orders listing).
     */
    public function productImage()
    {
        return $this->hasOne(ProductImage::class, 'product_unit_id', 'product_unit_id');
    }

    /**
     * Relationship: Get the product customization associated with this order item.
     * Assumes 'customization_id' exists on order_items table as a nullable foreign key.
     */
    public function customization()
    {
        return $this->belongsTo(ProductCustomization::class, 'customization_id', 'id');
    }
}
