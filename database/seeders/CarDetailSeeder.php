<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarDetail;
use App\Models\Car;
use App\Models\CarColor;

class CarDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available cars and colors
        $cars = Car::all();
        $colors = CarColor::all();

        // If no cars or colors are available, cannot create car details
        if ($cars->isEmpty() || $colors->isEmpty()) {
            return;
        }

        // Create sample car details
        $carDetails = [
            [
                'car_id' => $cars->random()->id,
                'color_id' => $colors->where('name', 'Red')->first()->id ?? $colors->random()->id,
                'quantity' => 5,
                'price' => 85000,
                'is_available' => true,
            ],
            [
                'car_id' => $cars->random()->id,
                'color_id' => $colors->where('name', 'Black')->first()->id ?? $colors->random()->id,
                'quantity' => 3,
                'price' => 120000,
                'is_available' => true,
            ],
            [
                'car_id' => $cars->random()->id,
                'color_id' => $colors->where('name', 'White')->first()->id ?? $colors->random()->id,
                'quantity' => 7,
                'price' => 75000,
                'is_available' => false,
            ],
            [
                'car_id' => $cars->random()->id,
                'color_id' => $colors->where('name', 'Blue')->first()->id ?? $colors->random()->id,
                'quantity' => 2,
                'price' => 95000,
                'is_available' => true,
            ],
        ];

        foreach ($carDetails as $detail) {
            CarDetail::create($detail);
        }
    }
}
