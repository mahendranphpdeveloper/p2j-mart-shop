<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomization extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'custom_text',
        'custom_image',
        'session_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userOrders()
    {
        return $this->hasMany(UserOrder::class, 'session_id', 'session_id');
    }
    
    // Accessor for the image URL
 public function getImageUrlAttribute()
{
    if (!$this->custom_image) {
        return null;
    }
    
    $fullPath = storage_path('app/public/' . $this->custom_image);
    
    if (!file_exists($fullPath)) {
        \Log::error('Custom image file missing', [
            'expected_path' => $fullPath,
            'customization_id' => $this->id
        ]);
        return null;
    }
    
    return asset('storage/' . $this->custom_image);
}
    /**
     * Get all OrderItems that use this customization.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'customization_id', 'id');
    }

}