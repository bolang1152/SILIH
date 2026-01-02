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
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel users
        $table->text('action');  // Deskripsi tindakan
        $table->foreignId('item_id')->nullable()->constrained()->onDelete('cascade');  // Relasi dengan tabel items
        $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade');  // Relasi dengan tabel rooms
        $table->text('details')->nullable();  // Detail tambahan
        $table->timestamps();  // Kolom created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('audit_logs');
}
};
