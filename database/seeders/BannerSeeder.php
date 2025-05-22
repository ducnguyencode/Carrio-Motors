<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample video URLs for banners
        $banners = [
            [
                'video_url' => 'videos/car_video1.mp4',
                'title' => 'Aventador V8',
                'subtitle' => 'Luxury meets performance',
                'main_content' => 'Experience the extraordinary with our flagship sports car',
                'car_id' => null, // Will be updated if car exists
                'click_url' => '/cars',
                'position' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'video_url' => 'videos/car_video2.mp4',
                'title' => 'Model S',
                'subtitle' => 'The future of driving',
                'main_content' => 'Revolutionary electric performance with unmatched range',
                'car_id' => null, // Will be updated if car exists
                'click_url' => '/cars',
                'position' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'video_url' => 'videos/car_video3.mp4',
                'title' => 'Urban Explorer',
                'subtitle' => 'Conquer the city streets',
                'main_content' => 'Compact, efficient and stylish - perfect for city driving',
                'car_id' => null, // Will be updated if car exists
                'click_url' => '/cars',
                'position' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Try to find cars by name and link them to banners
        foreach ($banners as $index => $banner) {
            $car = null;
            if ($banner['title'] === 'Aventador V8') {
                $car = DB::table('cars')->where('name', 'Aventador V8')->first();
            } elseif ($banner['title'] === 'Model S') {
                $car = DB::table('cars')->where('name', 'Model S')->first();
            }

            if ($car) {
                $banners[$index]['car_id'] = $car->id;
            }
        }

        // Insert banners
        DB::table('banners')->insert($banners);
    }
}
