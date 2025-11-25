<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Productunit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'product_unit';

    protected $primaryKey = 'product_unit_id';
    public $timestamps = true;

    // ProductUnit.php

    public function size()
    {
        return $this->belongsTo(UnitSize::class, 'm_size_id', 'm_size_id');
    }

    public function color()
    {
        return $this->belongsTo(UnitColor::class, 'm_color_id', 'm_color_id');
    }
       public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_unit_id', 'product_unit_id');
    }
    public function productimage()
    {
        return $this->belongsTo(ProductImage::class, 'product_unit_id', 'product_unit_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_unit_id', 'product_unit_id');
    }

    

}
