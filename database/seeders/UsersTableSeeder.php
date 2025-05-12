<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'username' => 'admin',
            'fullname' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'address' => '123 Admin St',
            'is_active' => true,
            'role' => 'admin',
        ]);

        // Saler user
        User::create([
            'username' => 'saler',
            'fullname' => 'Sales User',
            'email' => 'sales@example.com',
            'password' => Hash::make('password'),
            'phone' => '0987654321',
            'address' => '456 Sales Ave',
            'is_active' => true,
            'role' => 'saler',
        ]);

        // Regular user
        User::create([
            'username' => 'user',
            'fullname' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '0567891234',
            'address' => '789 User Blvd',
            'is_active' => true,
            'role' => 'user',
        ]);
    }
}
