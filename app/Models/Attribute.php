<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model {
    use HasFactory;

    protected $fillable = ['attribute_name', 'attribute_slug',  'display_order', 'status'];

}
