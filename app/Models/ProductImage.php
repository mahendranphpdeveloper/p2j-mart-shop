<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'product_image';

    protected $primaryKey = 'product_image_id';
    public $timestamps = true;
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
public function productUnit()
{
    return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'product_unit_id');
}
  // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        return asset('storage/products/' . $this->image);
    }
}
