<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'address_id',
        'payment_method',
        'total_amount',
        'status',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

 
    
public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
    
    public static function withDetails($id)
{
    return self::with(['user', 'product'])
        ->where('id', $id)
        ->firstOrFail();
}
}