<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_user';
    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Since your table uses 'username' for login
    public function username()
    {
        return 'username';
    }
}