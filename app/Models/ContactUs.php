<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_title',
        'meta_keywords',
        'meta_description',
        'address_title_1',
        'phone_title_1',
        'email_title_1',
        'address',
        'phone',
        'email',
        'embed_map_link',
        'form_title',
        'form_content',
    ];
}
