<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductCustomization extends Model
{
    use HasFactory;

    protected $table = 'order_product_customizations';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_unit_id',
        'order_item_id',
        'custom_text',
        'custom_attributes',
        'files',
    ];



    protected $casts = [
        'custom_attributes' => 'array',
        'files' => 'array',
    ];

    public $timestamps = true;
}
