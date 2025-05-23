<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarDetail;
use App\Models\CarColor;

class AdditionalCarDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();
        $colors = CarColor::all();

        if ($cars->isEmpty() || $colors->isEmpty()) {
            return;
        }

        foreach ($cars as $car) {
            // Only add details if none exist
            if ($car->carDetails()->exists()) {
                continue;
            }

            // Choose a random color
            $color = $colors->random();

            // Create a default car detail
            CarDetail::create([
                'car_id' => $car->id,
                'color_id' => $color->id,
                'quantity' => rand(1, 10),
                'price' => rand(20000, 100000),
                'is_available' => true,
                'main_image' => null,
                'additional_images' => null,
            ]);
        }
    }
}
