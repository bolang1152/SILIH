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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relasi dengan tabel users
        $table->string('phone_number')->nullable();  // Nomor telepon
        $table->text('address')->nullable();  // Alamat pengguna
        $table->text('bio')->nullable();  // Deskripsi pengguna
        $table->timestamps();  // Kolom created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('profiles');
}
};
