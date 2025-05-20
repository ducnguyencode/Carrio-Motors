<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Engine;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available models and engines
        $models = CarModel::all();
        $engines = Engine::all();

        // If no models or engines are available, cannot create cars
        if ($models->isEmpty() || $engines->isEmpty()) {
            return;
        }

        // Create sample cars
        $cars = [
            [
                'name' => 'Aventador V8',
                'model_id' => $models->where('name', 'Test Model')->first()->id ?? $models->random()->id,
                'engine_id' => $engines->random()->id,
                'transmission' => 'automatic',
                'seat_number' => 5,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'Powerful V8 engine with luxury interior',
                'is_featured' => false,
            ],
            [
                'name' => 'V8 New',
                'model_id' => $models->random()->id,
                'engine_id' => $engines->random()->id,
                'transmission' => 'automatic',
                'seat_number' => 5,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'Latest model with enhanced performance',
                'is_featured' => true,
            ],
            [
                'name' => 'GLE 450',
                'model_id' => $models->random()->id,
                'engine_id' => $engines->random()->id,
                'transmission' => 'automatic',
                'seat_number' => 7,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'Luxury SUV with spacious interior',
                'is_featured' => false,
            ],
            [
                'name' => 'Model S',
                'model_id' => $models->random()->id,
                'engine_id' => $engines->where('name', 'Test Engine')->first()->id ?? $engines->random()->id,
                'transmission' => 'automatic',
                'seat_number' => 5,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'All-electric sedan with cutting-edge technology',
                'is_featured' => true,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
