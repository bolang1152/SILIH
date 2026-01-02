<?php
// app/Models/Item.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan jika tidak mengikuti konvensi Laravel
    protected $table = 'items';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['name', 'description', 'quantity', 'status'];

    // Aturan casting untuk atribut
    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    // Jika ingin membuat relasi dengan model lain (misalnya ItemBorrowing)
    public function borrowings()
    {
        return $this->hasMany(ItemBorrowing::class);
    }
}

