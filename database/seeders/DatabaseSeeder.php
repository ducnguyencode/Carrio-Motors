<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}


//Sao datab
// bua em xoa het de chay thu
// em phai dong bo code ve roi moi lam chu
// bua em tai code chu kh co connect
// troi v gio
// de a thu connect coi sao, bao ghe
// okok

