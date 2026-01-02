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
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('name');  // Nama barang
        $table->text('description');  // Deskripsi barang
        $table->enum('status', ['available', 'borrowed', 'reserved'])->default('available');  // Status barang
        $table->integer('quantity')->default(1);  // Jumlah barang yang tersedia
        $table->timestamps();  // Kolom created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('items');
}
};
