<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKeypoints extends Model
{

    protected $table = 'product_keypoints';
    public $timestamps = false; // if timestamps are not present
protected $primaryKey = 'your_primary_key_column'; // if not 'id'

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
