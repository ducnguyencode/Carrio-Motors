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
        // Admin user (combining details from both seeders)
        User::create([
            'username' => 'admin',
            'fullname' => 'Duc Nguyen',
            'email' => 'manhthai123456@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '0981826971',
            'address' => 'Carrio Motors Headquarters',
            'is_active' => true,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Content manager user (new role for content management)
        User::create([
            'username' => 'content',
            'fullname' => 'Content Manager',
            'email' => 'content@example.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'address' => '123 Content St',
            'is_active' => true,
            'role' => 'content',
            'email_verified_at' => now(),
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
            'email_verified_at' => now(),
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
            'email_verified_at' => now(),
        ]);

        if (app()->runningInConsole()) {
            $this->command->info('Users created successfully!');
        }
    }
}
