<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarColor;

class CarColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Silver', 'hex_code' => '#C0C0C0'],
            ['name' => 'Gray', 'hex_code' => '#808080'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Green', 'hex_code' => '#008000'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
        ];

        foreach ($colors as $color) {
            CarColor::updateOrCreate(
                ['name' => $color['name']],
                ['hex_code' => $color['hex_code'], 'is_active' => true]
            );
        }
    }
}
