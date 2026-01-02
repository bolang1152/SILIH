<?php
// app/Models/Room.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan jika tidak mengikuti konvensi Laravel
    protected $table = 'rooms';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['name', 'description', 'capacity', 'status'];

    // Jika ingin membuat relasi dengan model lain (misalnya RoomBooking)
    public function bookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}

