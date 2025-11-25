<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $table = 'enquires';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];

    public $timestamps = true; // 🔴 Required to handle created_at and updated_at
}
