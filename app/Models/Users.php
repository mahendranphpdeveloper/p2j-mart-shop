<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Address;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $table = 'users';
    
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id'); // Explicitly set foreign key
    }

    public function orders()
    {
        return $this->hasMany(UserOrder::class);
    }
}