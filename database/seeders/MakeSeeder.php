<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Make;

class MakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makes = [
            ['name' => 'BMW', 'isActive' => true],
            ['name' => 'Mercedes-Benz', 'isActive' => true],
            ['name' => 'Audi', 'isActive' => true],
            ['name' => 'Toyota', 'isActive' => true],
            ['name' => 'Honda', 'isActive' => true],
            ['name' => 'Ford', 'isActive' => true],
            ['name' => 'Chevrolet', 'isActive' => true],
            ['name' => 'Volkswagen', 'isActive' => true],
            ['name' => 'Lamborghini', 'isActive' => true],
            ['name' => 'Ferrari', 'isActive' => true],
            ['name' => 'Porsche', 'isActive' => true],
            ['name' => 'Tesla', 'isActive' => true],
        ];

        foreach ($makes as $make) {
            Make::create($make);
        }
    }
}
