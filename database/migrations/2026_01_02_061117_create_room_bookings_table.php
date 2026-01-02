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
    Schema::create('room_bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel users
        $table->foreignId('room_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel rooms
        $table->timestamp('booked_at');  // Waktu pemesanan
        $table->timestamp('start_time')->nullable();  // Waktu mulai pemakaian
        $table->timestamp('end_time')->nullable();  // Waktu selesai pemakaian
        $table->enum('status', ['pending', 'confirmed', 'completed'])->default('pending');  // Status pemesanan
        $table->timestamps();  // Kolom created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('room_bookings');
}
};
