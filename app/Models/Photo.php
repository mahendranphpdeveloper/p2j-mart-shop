<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'product_id',
        'photo_path',
        'alt_text',
        'is_primary',
    ];

    public function photos()
{
    return $this->hasMany(Photo::class);
}

}
