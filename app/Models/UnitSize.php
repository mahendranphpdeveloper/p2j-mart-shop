<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitSize extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'm_size';

    protected $primaryKey = 'm_size_id'; // Set the correct primary key
    public $incrementing = false; // if it's not auto-increment
    public $timestamps = true;  

    public function productUnits()
    {
        return $this->hasMany(ProductUnit::class, 'm_size_id', 'm_size_id');
    }
}
