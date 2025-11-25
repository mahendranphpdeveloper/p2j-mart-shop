<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $table = 'user_orders';
    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $guarded = [];
    protected $fillable = [
        'user_id', 'product_id', 'product_unit_id', 'quantity',
        'address_id', 'total_amount', 'shipping_cost', 'payment_status',
        'order_status', 'transaction_id', 'session_id', 'cancel_order_reason', 'return_details',
    ];
    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function unit()
    {
        return $this->belongsTo(Productunit::class, 'product_unit_id');
    }

    /**
     * Get the order items for this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function getAmountAttribute()
    {
        return $this->total_amount;
    }

    public function isPayable()
    {
        return $this->payment_status === 'pending' &&
            in_array($this->order_status, ['confirmed', 'pending', 'processing']);
    }

    public function markAsPaid()
    {
        $this->update([
            'payment_status' => 'Success',
            'order_status' => 'processing'
        ]);
    }

    public function getRouteKeyName()
    {
        return 'order_id';
    }

    public function productImages()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
    }

    public function cancel(string $reason)
    {
        $this->update([
            'order_status' => 'cancelled',
            'cancel_order_reason' => $reason,
        ]);
    }

    public function return(array $data)
    {
        $this->update([
            'order_status' => 'returned',
            'return_reason' => $data['return_reason'],
            'return_details' => $data['return_details'] ?? null,
        ]);
    }

    public function productImage()
    {
        return $this->hasOneThrough(
            ProductImage::class,
            Product::class,
            'product_id', // Foreign key on products table
            'product_id', // Foreign key on product_images table
            'product_id', // Local key on user_orders table
            'product_id'  // Local key on products table
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    public function units()
    {
        return $this->hasMany(Productunit::class, 'product_id', 'product_id')->where('is_deleted', 0);
    }

    public function productUnit()
    {
        return $this->hasOne(Productunit::class, 'product_id', 'product_id');
    }

    public function customization()
    {
        return $this->hasOne(ProductCustomization::class, 'product_id', 'product_id');
    }
}

