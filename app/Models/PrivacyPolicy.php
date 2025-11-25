<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $table = 'privacy_policy'; // Define the custom table name

    protected $fillable = ['title', 'content'];
}
