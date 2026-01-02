<?php
// app/Models/ItemBorrowing.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBorrowing extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan jika tidak mengikuti konvensi Laravel
    protected $table = 'item_borrowings';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['user_id', 'item_id', 'borrowed_at', 'due_date', 'returned_at', 'status'];

    // Relasi dengan model User dan Item
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

