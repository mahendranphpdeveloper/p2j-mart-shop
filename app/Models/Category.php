<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'title',
        'image',
        'category_slug',
        'description',
        'status',
        'display_order',
    ];

    // Optionally, you can add a method to generate the category slug automatically
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Automatically create a slug from the category title
            $category->category_slug = \Illuminate\Support\Str::slug($category->title);
        });


        static::updating(function ($category) {
            // Check if the category slug has been updated
            if ($category->isDirty('category_slug')) {
                // Update all related subcategories' category_slug if needed
                \App\Models\SubCategory::where('category_id', $category->id)
                    ->update(['category_slug' => $category->category_slug]);
            }
        });
    }
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
    
    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class, 'category_id', 'subcategory_id');
    }
    
}
