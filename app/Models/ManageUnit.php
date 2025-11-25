<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManageUnit extends Model {
    use HasFactory;

    protected $fillable = ['color', 'size', 'material', 'weight', 'unit_count'];
}
