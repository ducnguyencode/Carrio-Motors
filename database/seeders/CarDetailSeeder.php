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

        // Find Aventador V8
        $aventador = $cars->where('name', 'Aventador V8')->first();

        // Create specific color variants for Aventador
        if ($aventador) {
            // Silver variant
            CarDetail::create([
                'car_id' => $aventador->id,
                'color_id' => $colors->where('name', 'Silver')->first()->id ?? $colors->random()->id,
                'quantity' => 4,
                'price' => 9000,
                'is_available' => true,
                'main_image' => 'images/cars/aventador-silver.jpg',
                'additional_images' => json_encode([
                    'images/cars/aventador-silver-interior.jpg',
                    'images/cars/aventador-silver-side.jpg',
                    'images/cars/aventador-silver-back.jpg'
                ])
            ]);

            // Black variant
            CarDetail::create([
                'car_id' => $aventador->id,
                'color_id' => $colors->where('name', 'Black')->first()->id ?? $colors->random()->id,
                'quantity' => 12,
                'price' => 90000,
                'is_available' => true,
                'main_image' => 'images/cars/aventador-black.jpg',
                'additional_images' => json_encode([
                    'images/cars/aventador-black-interior.jpg',
                    'images/cars/aventador-black-side.jpg',
                    'images/cars/aventador-black-back.jpg'
                ])
            ]);
        }

        // Find Model S
        $modelS = $cars->where('name', 'Model S')->first();

        if ($modelS) {
            // Gray variant
            CarDetail::create([
                'car_id' => $modelS->id,
                'color_id' => $colors->where('name', 'Gray')->first()->id ?? $colors->random()->id,
                'quantity' => 12,
                'price' => 98000,
                'is_available' => true,
                'main_image' => 'images/cars/model-s-gray.jpg',
                'additional_images' => json_encode([
                    'images/cars/model-s-gray-interior.jpg',
                    'images/cars/model-s-gray-side.jpg'
                ])
            ]);
        }

        // Find GLE 450
        $gle = $cars->where('name', 'GLE 450')->first();

        if ($gle) {
            // Black variant
            CarDetail::create([
                'car_id' => $gle->id,
                'color_id' => $colors->where('name', 'Black')->first()->id ?? $colors->random()->id,
                'quantity' => 3,
                'price' => 120000,
                'is_available' => true,
                'main_image' => 'images/cars/gle-black.jpg',
                'additional_images' => json_encode([
                    'images/cars/gle-black-interior.jpg',
                    'images/cars/gle-black-side.jpg'
                ])
            ]);

            // Blue variant
            CarDetail::create([
                'car_id' => $gle->id,
                'color_id' => $colors->where('name', 'Blue')->first()->id ?? $colors->random()->id,
                'quantity' => 2,
                'price' => 95000,
                'is_available' => true,
                'main_image' => 'images/cars/gle-blue.jpg',
                'additional_images' => json_encode([
                    'images/cars/gle-blue-interior.jpg',
                    'images/cars/gle-blue-side.jpg'
                ])
            ]);
        }

        // Find V8 New
        $v8New = $cars->where('name', 'V8 New')->first();

        if ($v8New) {
            // White variant
            CarDetail::create([
                'car_id' => $v8New->id,
                'color_id' => $colors->where('name', 'White')->first()->id ?? $colors->random()->id,
                'quantity' => 5,
                'price' => 75000,
                'is_available' => true,
                'main_image' => 'images/cars/v8-new-white.jpg',
                'additional_images' => json_encode([
                    'images/cars/v8-new-white-interior.jpg',
                    'images/cars/v8-new-white-side.jpg'
                ])
            ]);

            // Orange variant
            CarDetail::create([
                'car_id' => $v8New->id,
                'color_id' => $colors->where('name', 'Orange')->first()->id ?? $colors->random()->id,
                'quantity' => 3,
                'price' => 85000,
                'is_available' => true,
                'main_image' => 'images/cars/v8-new-orange.jpg',
                'additional_images' => json_encode([
                    'images/cars/v8-new-orange-interior.jpg',
                    'images/cars/v8-new-orange-side.jpg'
                ])
            ]);
        }

        // Find Nana
        $nana = $cars->where('name', 'Nana')->first();

        if ($nana) {
            // Black variant
            CarDetail::create([
                'car_id' => $nana->id,
                'color_id' => $colors->where('name', 'Black')->first()->id ?? $colors->random()->id,
                'quantity' => 15,
                'price' => 20000,
                'is_available' => true,
                'main_image' => 'images/cars/nana-black.jpg',
                'additional_images' => json_encode([
                    'images/cars/nana-black-interior.jpg',
                    'images/cars/nana-black-side.jpg'
                ])
            ]);

            // Blue variant
            CarDetail::create([
                'car_id' => $nana->id,
                'color_id' => $colors->where('name', 'Blue')->first()->id ?? $colors->random()->id,
                'quantity' => 8,
                'price' => 22000,
                'is_available' => true,
                'main_image' => 'images/cars/nana-blue.jpg',
                'additional_images' => json_encode([
                    'images/cars/nana-blue-interior.jpg',
                    'images/cars/nana-blue-side.jpg'
                ])
            ]);
        }

        // Find Roadster Z
        $roadsterZ = $cars->where('name', 'Roadster Z')->first();

        if ($roadsterZ) {
            // Black variant
            CarDetail::create([
                'car_id' => $roadsterZ->id,
                'color_id' => $colors->where('name', 'Black')->first()->id ?? $colors->random()->id,
                'quantity' => 3,
                'price' => 9000,
                'is_available' => true,
                'main_image' => 'images/cars/roadster-black.jpg',
                'additional_images' => json_encode([
                    'images/cars/roadster-black-interior.jpg',
                    'images/cars/roadster-black-side.jpg'
                ])
            ]);

            // Blue variant
            CarDetail::create([
                'car_id' => $roadsterZ->id,
                'color_id' => $colors->where('name', 'Blue')->first()->id ?? $colors->random()->id,
                'quantity' => 6,
                'price' => 9500,
                'is_available' => true,
                'main_image' => 'images/cars/roadster-blue.jpg',
                'additional_images' => json_encode([
                    'images/cars/roadster-blue-interior.jpg',
                    'images/cars/roadster-blue-side.jpg'
                ])
            ]);
        }

        // Find City Compact
        $cityCompact = $cars->where('name', 'City Compact')->first();

        if ($cityCompact) {
            // Red variant
            CarDetail::create([
                'car_id' => $cityCompact->id,
                'color_id' => $colors->where('name', 'Red')->first()->id ?? $colors->random()->id,
                'quantity' => 10,
                'price' => 12000,
                'is_available' => true,
                'main_image' => 'images/cars/city-red.jpg',
                'additional_images' => json_encode([
                    'images/cars/city-red-interior.jpg',
                    'images/cars/city-red-side.jpg'
                ])
            ]);

            // White variant
            CarDetail::create([
                'car_id' => $cityCompact->id,
                'color_id' => $colors->where('name', 'White')->first()->id ?? $colors->random()->id,
                'quantity' => 8,
                'price' => 13000,
                'is_available' => true,
                'main_image' => 'images/cars/city-white.jpg',
                'additional_images' => json_encode([
                    'images/cars/city-white-interior.jpg',
                    'images/cars/city-white-side.jpg'
                ])
            ]);

            // Orange variant
            CarDetail::create([
                'car_id' => $cityCompact->id,
                'color_id' => $colors->where('name', 'Orange')->first()->id ?? $colors->random()->id,
                'quantity' => 5,
                'price' => 15000,
                'is_available' => true,
                'main_image' => 'images/cars/city-orange.jpg',
                'additional_images' => json_encode([
                    'images/cars/city-orange-interior.jpg',
                    'images/cars/city-orange-side.jpg'
                ])
            ]);
        }
    }
}
