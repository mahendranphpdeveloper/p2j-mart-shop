<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaDescription extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'product_meta_description';
}
