<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gst extends Model
{
    protected $table = 'gst'; // just to be explicit
    protected $fillable = ['gst_status', 'gst_percentage', 'category_name'];
}
