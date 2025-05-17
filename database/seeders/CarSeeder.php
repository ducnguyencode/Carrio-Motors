<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Make;
use App\Models\CarModel;
use App\Models\Engine;
use App\Models\Car;
use App\Models\CarColor;
use App\Models\CarDetail;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        // Create car makes
        $makes = [
            [
                'name' => 'Toyota',
                'description' => 'Japanese automotive manufacturer'
            ],
            [
                'name' => 'Honda',
                'description' => 'Japanese automotive and motorcycle manufacturer'
            ],
            [
                'name' => 'BMW',
                'description' => 'German luxury automobile manufacturer'
            ]
        ];

        foreach ($makes as $makeData) {
            $make = Make::create($makeData);

            // Create models for each make
            $models = [
                $make->name === 'Toyota' ? [
                    ['name' => 'Camry', 'year' => 2024],
                    ['name' => 'RAV4', 'year' => 2024],
                    ['name' => 'Corolla', 'year' => 2024]
                ] : ($make->name === 'Honda' ? [
                    ['name' => 'Civic', 'year' => 2024],
                    ['name' => 'CR-V', 'year' => 2024],
                    ['name' => 'Accord', 'year' => 2024]
                ] : [
                    ['name' => '3 Series', 'year' => 2024],
                    ['name' => 'X5', 'year' => 2024],
                    ['name' => '5 Series', 'year' => 2024]
                ])
            ];

            foreach ($models[0] as $modelData) {
                $model = CarModel::create([
                    'name' => $modelData['name'],
                    'year' => $modelData['year'],
                    'make_id' => $make->id
                ]);
            }
        }

        // Create engines
        $engines = [
            [
                'name' => '2.5L 4-Cylinder',
                'displacement' => 2.5,
                'cylinders' => 4,
                'power' => 203,
                'torque' => 250,
                'fuel_type' => 'gasoline'
            ],
            [
                'name' => '3.5L V6',
                'displacement' => 3.5,
                'cylinders' => 6,
                'power' => 300,
                'torque' => 350,
                'fuel_type' => 'gasoline'
            ],
            [
                'name' => '2.0L Turbo',
                'displacement' => 2.0,
                'cylinders' => 4,
                'power' => 255,
                'torque' => 300,
                'fuel_type' => 'gasoline'
            ]
        ];

        foreach ($engines as $engineData) {
            Engine::create($engineData);
        }

        // Create colors
        $colors = [
            ['name' => 'Pearl White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Midnight Black', 'hex_code' => '#000000'],
            ['name' => 'Silver Sky', 'hex_code' => '#C0C0C0'],
            ['name' => 'Ruby Red', 'hex_code' => '#FF0000']
        ];

        foreach ($colors as $colorData) {
            CarColor::create($colorData);
        }

        // Create cars and their details
        $models = CarModel::with('make')->get();
        $engines = Engine::all();
        $colors = CarColor::all();

        foreach ($models as $model) {
            // Create 1-2 cars for each model
            for ($i = 0; $i < rand(1, 2); $i++) {
                $car = Car::create([
                    'name' => $model->make->name . ' ' . $model->name . ' ' . ($i + 1),
                    'brand' => $model->make->name,
                    'model_id' => $model->id,
                    'engine_id' => $engines->random()->id,
                    'transmission' => rand(0, 1) ? 'automatic' : 'manual',
                    'seats' => rand(0, 1) ? 5 : 7,
                    'status' => true
                ]);

                // Create car details for each color
                foreach ($colors as $color) {
                    CarDetail::create([
                        'car_id' => $car->id,
                        'color_id' => $color->id,
                        'quantity' => rand(1, 5),
                        'price' => rand(30000, 80000)
                    ]);
                }
            }
        }
    }
}
