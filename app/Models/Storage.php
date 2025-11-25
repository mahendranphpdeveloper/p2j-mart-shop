<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'm_storage';
    protected $primaryKey = 'm_storage_id';
    public $incrementing = true;
    public $timestamps = true;
}