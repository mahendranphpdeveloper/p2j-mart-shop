<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductCustomization extends Model
{
    use HasFactory;

    protected $table = 'order_product_customizations';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'custom_text',
        'custom_attributes',
        'files',
    ];
    zdCREATE TABLE `order_product_customizations` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    `order_id` BIGINT UNSIGNED NOT NULL,
    `order_item_id` BIGINT UNSIGNED NOT NULL,

    `custom_text` TEXT NULL,
    `custom_attributes` JSON NULL,
    `files` JSON NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,

    PRIMARY KEY (`id`)
    );

    protected $casts = [
        'custom_attributes' => 'array',
        'files' => 'array',
    ];
}
