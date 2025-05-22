<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Approach 1: Deactivate cars with name 'Aventador V8' or 'V8 New' that have $0 price details
        $carNames = ['Aventador V8', 'V8 New'];

        foreach ($carNames as $carName) {
            $cars = DB::table('cars')
                ->where('name', $carName)
                ->get();

            foreach ($cars as $car) {
                // Check if all car details have zero price
                $totalDetails = DB::table('cars_details')
                    ->where('car_id', $car->id)
                    ->count();

                if ($totalDetails == 0) {
                    // No details, skip this car
                    continue;
                }

                $zeroPriceDetails = DB::table('cars_details')
                    ->where('car_id', $car->id)
                    ->where(function($query) {
                        $query->where('price', 0)
                              ->orWhere('price', '0')
                              ->orWhere('price', '0.00')
                              ->orWhere('price', 0.00);
                    })
                    ->count();

                // If all details have zero price, deactivate the car
                if ($zeroPriceDetails == $totalDetails) {
                    DB::table('cars')
                        ->where('id', $car->id)
                        ->update(['status' => false]);

                    // Log the update
                    DB::table('logs')->insert([
                        'message' => "Deactivated {$carName} car ID {$car->id} due to zero price",
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        // Approach 2: Find cars that have all details with zero price
        $allCars = DB::table('cars')->get();

        foreach ($allCars as $car) {
            // Skip cars that don't have any details
            $totalDetails = DB::table('cars_details')
                ->where('car_id', $car->id)
                ->count();

            if ($totalDetails == 0) {
                continue;
            }

            // Count zero price details
            $zeroPriceDetails = DB::table('cars_details')
                ->where('car_id', $car->id)
                ->where(function($query) {
                    $query->where('price', 0)
                          ->orWhere('price', '0')
                          ->orWhere('price', '0.00')
                          ->orWhere('price', 0.00);
                })
                ->count();

            // If all details have zero price, deactivate the car
            if ($zeroPriceDetails == $totalDetails) {
                DB::table('cars')
                    ->where('id', $car->id)
                    ->update(['status' => false]);

                // Log the update
                DB::table('logs')->insert([
                    'message' => "Deactivated car ID {$car->id} name {$car->name} due to zero price in all details",
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reactivate cars that were deactivated
        $carNames = ['Aventador V8', 'V8 New'];

        foreach ($carNames as $carName) {
            DB::table('cars')
                ->where('name', $carName)
                ->update(['status' => true]);
        }
    }
};
