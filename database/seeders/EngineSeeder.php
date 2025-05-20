<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Engine;

class EngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $engines = [
            [
                'name' => 'V8 Gasoline',
                'horsepower' => 500,
                'level' => '4.0L',
                'max_speed' => 300,
                'drive_type' => 'RWD',
                'engine_type' => 'Gasoline',
                'isActive' => true,
            ],
            [
                'name' => 'V6 Gasoline',
                'horsepower' => 350,
                'level' => '3.0L',
                'max_speed' => 250,
                'drive_type' => 'AWD',
                'engine_type' => 'Gasoline',
                'isActive' => true,
            ],
            [
                'name' => 'Inline 4 Gasoline',
                'horsepower' => 220,
                'level' => '2.0L',
                'max_speed' => 220,
                'drive_type' => 'FWD',
                'engine_type' => 'Gasoline',
                'isActive' => true,
            ],
            [
                'name' => 'Diesel V6',
                'horsepower' => 280,
                'level' => '3.0L',
                'max_speed' => 230,
                'drive_type' => 'AWD',
                'engine_type' => 'Diesel',
                'isActive' => true,
            ],
            [
                'name' => 'Electric',
                'horsepower' => 450,
                'level' => 'N/A',
                'max_speed' => 250,
                'drive_type' => 'AWD',
                'engine_type' => 'Electric',
                'isActive' => true,
            ],
            [
                'name' => 'Hybrid',
                'horsepower' => 320,
                'level' => '2.5L',
                'max_speed' => 220,
                'drive_type' => 'AWD',
                'engine_type' => 'Hybrid',
                'isActive' => true,
            ],
        ];

        foreach ($engines as $engine) {
            Engine::create($engine);
        }
    }
}
