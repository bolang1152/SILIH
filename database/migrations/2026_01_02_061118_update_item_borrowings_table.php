<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update status enum untuk item_borrowings
        DB::statement("ALTER TABLE item_borrowings MODIFY COLUMN status ENUM('pending', 'borrowed', 'rejected', 'completed') DEFAULT 'pending'");

        // Tambah kolom rejection_reason
        Schema::table('item_borrowings', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_borrowings', function (Blueprint $table) {
            $table->dropColumn(['rejection_reason']);
        });

        // Restore status enum
        DB::statement("ALTER TABLE item_borrowings MODIFY COLUMN status ENUM('pending', 'completed', 'overdue') DEFAULT 'pending'");
    }
};

