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
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('name');  // Nama ruangan
        $table->text('description');  // Deskripsi ruangan
        $table->integer('capacity');  // Kapasitas ruangan
        $table->enum('status', ['available', 'booked'])->default('available');  // Status ruangan
        $table->timestamps();  // Kolom created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('rooms');
}
};
