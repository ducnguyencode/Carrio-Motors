<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Engine;

class AdditionalCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = CarModel::all();
        $engines = Engine::all();

        if ($models->isEmpty() || $engines->isEmpty()) {
            return;
        }

        foreach ($models as $model) {
            $existingCount = Car::where('model_id', $model->id)->count();
            // Ensure at least 3 cars per model for similar cars
            for ($i = $existingCount; $i < 3; $i++) {
                Car::create([
                    'name' => $model->name . ' Variant ' . ($i + 1),
                    'model_id' => $model->id,
                    'engine_id' => $engines->random()->id,
                    'transmission' => 'automatic',
                    'seat_number' => 5,
                ]);
            }
        }
    }
}
