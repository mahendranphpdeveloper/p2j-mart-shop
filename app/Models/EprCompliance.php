<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EprCompliance extends Model
{
    use HasFactory;

    // Table name (optional if it matches the default)
    protected $table = 'epr_compliance'; 

    // Fillable fields
    protected $fillable = ['title', 'content'];
}
