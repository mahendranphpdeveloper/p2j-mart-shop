<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMaterial extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'm_material';
}
