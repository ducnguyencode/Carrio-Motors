<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'fullname' => 'System Administrator',
            'email' => 'admin@carriomotors.com',
            'password' => Hash::make('password123'),
            'phone' => '0123456789',
            'address' => 'Carrio Motors Headquarters',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        $this->command->info('Admin user created successfully!');
    }
}
