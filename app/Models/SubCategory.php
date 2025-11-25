<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories'; // Just to be explicit

    protected $fillable = [
        'title',
        'image',
        'subcategory_slug',
        'category_id',
        'category_slug',
        'description',
        'selected_attributes',
        'status',
        'display_order',
    ];

    // Create slug automatically for subcategories
    public static function boot()
    {
        parent::boot();
        static::creating(function ($subcategory) {
            $subcategory->subcategory_slug = \Illuminate\Support\Str::slug($subcategory->title);
        });
    }

    // Define the relationship with Category
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    protected $casts = [
        'selected_attributes' => 'array', // Automatically decode JSON to array
    ];

    public function products() {
        return $this->hasMany(Product::class, 'subcategory_id'); // adjust if your foreign key is named differently
    }
    
}
