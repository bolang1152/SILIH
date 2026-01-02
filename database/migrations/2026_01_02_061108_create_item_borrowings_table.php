<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('item_borrowings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('user')->onDelete('cascade');  // Relasi dengan tabel user
        $table->foreignId('item_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel items
        $table->timestamp('borrowed_at');  // Waktu peminjaman barang
        $table->timestamp('due_date')->nullable();  // Tanggal pengembalian yang diharapkan
        $table->timestamp('returned_at')->nullable();  // Waktu pengembalian (null jika belum dikembalikan)
        $table->enum('status', ['pending', 'completed', 'overdue'])->default('pending');  // Status peminjaman
        $table->timestamps();  // Kolom created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('item_borrowings');
}
};
