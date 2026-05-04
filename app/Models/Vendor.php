<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Must extend this
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $guard = 'vendor';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
}
