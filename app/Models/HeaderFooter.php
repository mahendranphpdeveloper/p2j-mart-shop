<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderFooter extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $except = [];
    protected $table = 'header_footer';
}
