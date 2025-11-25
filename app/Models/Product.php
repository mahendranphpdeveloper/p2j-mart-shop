<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductMetaTitle;
use App\Models\ProductMetaDescription;
use App\Models\ProductKeypoints;


    class Product extends Model
    {
        use HasFactory;
        protected $guarded = [];
        protected $except = [];
        protected $table = 'product';
        protected $primaryKey = 'product_id';
        public $incrementing = true;



        public function subcategory()
        {
            return $this->belongsTo(SubCategory::class, 'subcategory_id');
        }
        
    
public function units()
{
    return $this->hasMany(Productunit::class, 'product_id', 'product_id')->where('is_deleted', 0);
}

public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}




public function metaTitle()
{
    return $this->hasOne(ProductMetaTitle::class, 'product_id', 'id');
}

public function metaDescription()
{
    return $this->hasOne(ProductMetaDescription::class, 'product_id', 'id');
}

public function keypoints()
{
    return $this->hasMany(ProductKeypoints::class, 'product_id', 'id');
}

public function sizes()
{
    return $this->hasManyThrough(UnitSize::class, ProductUnit::class, 'product_id', 'm_size_id');
}

public function colors()
{
    return $this->hasManyThrough(UnitColor::class, ProductUnit::class, 'product_id', 'm_color_id');
}

public function design()
{
    return $this->hasMany(\App\Models\UnitDesign::class, 'product_id');
}
// public function Matrial()
// {
//     return $this->hasMany(\App\Models\UnitMatrial::class, 'product_id');
// }
public function Matrial()
{
    return $this->hasManyThrough(UnitMatrial::class, ProductUnit::class, 'product_id', 'm_material_id');
}

public function productImage()
{
    return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
}


public function category()
{
    return $this->belongsTo(Category::class, 'cate_id');
}

public function productUnit()
{
    return $this->hasOne(Productunit::class, 'product_id', 'product_id');
}

public function product_image()
{
   return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
}

// app/Models/Product.php

public function getWeightInGrams()
{
    if (!$this->weight || !$this->weight_unit) {
        return 0;
    }

    $weight = (float)$this->weight;
    $unit = strtolower($this->weight_unit);

    switch ($unit) {
        case 'kg':
            return $weight * 1000;
        case 'g':
            return $weight;
        case 'mg':
            return $weight / 1000;
        case 'lb':
            return $weight * 453.592;
        case 'oz':
            return $weight * 28.3495;
        default:
            return $weight; // assume grams if unit unknown
    }
}

}
