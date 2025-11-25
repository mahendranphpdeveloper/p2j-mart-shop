<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'city',
        'pincode',
        'state',
        'type',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
    

    public function getFullAddressAttribute() {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->pincode}";
    }
}