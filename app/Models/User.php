<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'google_id', 
        'permissions', // 🔥 Add this line
        'enquiry', // Add this line

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // In the User model
protected $casts = [
    'permissions' => 'array', // If stored as JSON
];

public function hasPermission($permission)
{
    // Always allow admin (ID=1)
    if ($this->id === 1) {
        return true;
    }
    
    // Check permissions array
    if (!isset($this->permissions) || !is_array($this->permissions)) {
        return false;
    }
    
    return $this->permissions[$permission] ?? false;
}



}
