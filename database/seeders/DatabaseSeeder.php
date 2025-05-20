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
        $this->call([
            UsersTableSeeder::class,
            CarColorSeeder::class,
            // First we need Makes, Models and Engines before we can create Cars
            MakeSeeder::class,
            EngineSeeder::class,
            ModelSeeder::class,
            // Then we can create Cars
            CarSeeder::class,
            // Finally we can create Car Details
            CarDetailSeeder::class
        ]);
    }
}
