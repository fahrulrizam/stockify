<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // jangan lupa tambahkan role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
    'email_verified_at' => 'datetime',
    // ...
    // Pastikan jika ada cast untuk role, itu benar
];

    // Otomatis hash password saat diset
    protected function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            // Jika belum di-hash, hash pakai Bcrypt
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }
}
