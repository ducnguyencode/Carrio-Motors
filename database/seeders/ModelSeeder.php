<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel;
use App\Models\Make;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all makes
        $makes = Make::all();

        if ($makes->isEmpty()) {
            return;
        }

        $bmwId = $makes->where('name', 'BMW')->first()->id ?? null;
        $mercedesId = $makes->where('name', 'Mercedes-Benz')->first()->id ?? null;
        $audiId = $makes->where('name', 'Audi')->first()->id ?? null;
        $lamborghiniId = $makes->where('name', 'Lamborghini')->first()->id ?? null;
        $teslaId = $makes->where('name', 'Tesla')->first()->id ?? null;

        // Create sample models
        $models = [
            ['name' => '3 Series', 'make_id' => $bmwId ?? $makes->random()->id, 'isActive' => true],
            ['name' => '5 Series', 'make_id' => $bmwId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'X5', 'make_id' => $bmwId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'C-Class', 'make_id' => $mercedesId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'E-Class', 'make_id' => $mercedesId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'GLE', 'make_id' => $mercedesId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'A4', 'make_id' => $audiId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'Q7', 'make_id' => $audiId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'Aventador', 'make_id' => $lamborghiniId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'Huracan', 'make_id' => $lamborghiniId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'Model S', 'make_id' => $teslaId ?? $makes->random()->id, 'isActive' => true],
            ['name' => 'Model 3', 'make_id' => $teslaId ?? $makes->random()->id, 'isActive' => true],
        ];

        foreach ($models as $model) {
            CarModel::create($model);
        }
    }
}
