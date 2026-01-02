<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        DB::table('user')->insert([
            'name' => 'Administrator',
            'email' => 'admin@silih.id',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@silih.id');
        $this->command->info('Password: admin123');
    }
}

