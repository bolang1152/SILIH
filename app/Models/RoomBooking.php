<?php
// app/Models/RoomBooking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan jika tidak mengikuti konvensi Laravel
    protected $table = 'room_bookings';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['user_id', 'room_id', 'start_time', 'end_time', 'status'];

    // Relasi dengan model User dan Room
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

