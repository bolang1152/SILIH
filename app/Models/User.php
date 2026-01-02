<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user'; // Menggunakan tabel 'user' bukan 'users'

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi dengan ItemBorrowing
    public function itemBorrowings()
    {
        return $this->hasMany(ItemBorrowing::class);
    }

    // Relasi dengan RoomBooking
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}
