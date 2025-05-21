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
                'reviews_count' => 43,
                'rating' => 4.5,
                'horsepower' => '670 hp',
                'torque' => '600 lb-ft',
                'acceleration' => '3.2 seconds (0-60 mph)',
                'fuel_consumption' => '12 MPG city / 18 MPG highway',
                'length' => '188.8 inches (4,797 mm)',
                'width' => '79.9 inches (2,030 mm)',
                'height' => '44.7 inches (1,136 mm)',
                'cargo_volume' => '5.3 cubic feet',
                'fuel_capacity' => '23.8 gallons',
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
                'reviews_count' => 35,
                'rating' => 4.5,
                'horsepower' => '550 hp',
                'torque' => '502 lb-ft',
                'acceleration' => '3.5 seconds (0-60 mph)',
                'fuel_consumption' => '13 MPG city / 19 MPG highway',
                'length' => '187.4 inches (4,760 mm)',
                'width' => '77.5 inches (1,968 mm)',
                'height' => '45.9 inches (1,166 mm)',
                'cargo_volume' => '4.4 cubic feet',
                'fuel_capacity' => '20.3 gallons',
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
                'reviews_count' => 14,
                'rating' => 3.5,
                'horsepower' => '362 hp',
                'torque' => '369 lb-ft',
                'acceleration' => '5.6 seconds (0-60 mph)',
                'fuel_consumption' => '19 MPG city / 24 MPG highway',
                'length' => '194.3 inches (4,935 mm)',
                'width' => '84.9 inches (2,157 mm)',
                'height' => '70.7 inches (1,795 mm)',
                'cargo_volume' => '33.3 cubic feet',
                'fuel_capacity' => '22.5 gallons',
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
                'reviews_count' => 36,
                'rating' => 4.5,
                'horsepower' => '670 hp',
                'torque' => '723 lb-ft',
                'acceleration' => '3.1 seconds (0-60 mph)',
                'fuel_consumption' => 'Electric - 120 MPGe',
                'length' => '196 inches (4,970 mm)',
                'width' => '77.3 inches (1,964 mm)',
                'height' => '56.9 inches (1,445 mm)',
                'cargo_volume' => '28 cubic feet',
                'fuel_capacity' => '100 kWh Battery',
            ],
            [
                'name' => 'Nana',
                'model_id' => $models->random()->id,
                'engine_id' => $engines->random()->id,
                'transmission' => 'automatic',
                'seat_number' => 5,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'Sleek design with powerful performance',
                'is_featured' => true,
                'reviews_count' => 30,
                'rating' => 5.0,
                'horsepower' => '245 hp',
                'torque' => '258 lb-ft',
                'acceleration' => '6.4 seconds (0-60 mph)',
                'fuel_consumption' => '25 MPG city / 32 MPG highway',
                'length' => '185.5 inches (4,712 mm)',
                'width' => '75.1 inches (1,908 mm)',
                'height' => '55.3 inches (1,404 mm)',
                'cargo_volume' => '15.7 cubic feet',
                'fuel_capacity' => '16.0 gallons',
            ],
            [
                'name' => 'Roadster Z',
                'model_id' => $models->random()->id,
                'engine_id' => $engines->random()->id,
                'transmission' => 'manual',
                'seat_number' => 2,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'Sporty convertible with incredible handling',
                'is_featured' => false,
                'reviews_count' => 50,
                'rating' => 4.5,
                'horsepower' => '300 hp',
                'torque' => '280 lb-ft',
                'acceleration' => '4.8 seconds (0-60 mph)',
                'fuel_consumption' => '20 MPG city / 28 MPG highway',
                'length' => '172.4 inches (4,379 mm)',
                'width' => '73.0 inches (1,854 mm)',
                'height' => '51.4 inches (1,306 mm)',
                'cargo_volume' => '7.5 cubic feet',
                'fuel_capacity' => '13.5 gallons',
            ],
            [
                'name' => 'City Compact',
                'model_id' => $models->random()->id,
                'engine_id' => $engines->random()->id,
                'transmission' => 'automatic',
                'seat_number' => 5,
                'isActive' => true,
                'date_manufactured' => now(),
                'description' => 'Economical city car with excellent fuel efficiency',
                'is_featured' => false,
                'reviews_count' => 28,
                'rating' => 3.0,
                'horsepower' => '158 hp',
                'torque' => '138 lb-ft',
                'acceleration' => '8.0 seconds (0-60 mph)',
                'fuel_consumption' => '32 MPG city / 42 MPG highway',
                'length' => '168.5 inches (4,280 mm)',
                'width' => '70.9 inches (1,801 mm)',
                'height' => '57.1 inches (1,450 mm)',
                'cargo_volume' => '15.1 cubic feet',
                'fuel_capacity' => '11.8 gallons',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
