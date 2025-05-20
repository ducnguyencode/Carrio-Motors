<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarDetail;
use App\Models\Banner;

use Illuminate\Support\Collection;

class PageController extends Controller
{
    public function home() {
        $useMockData = true;

        if ($useMockData) {
            $featuredCars = [[
                    'id' => 1,
                    'name' => 'Toyota Supra',
                    'image_url' => asset('images/cars/supra.jpg'),
                    'rating' => 4.8,
                    'reviews' => 120,
                    'is_best_seller' => true,
                    'price' => 45000,
                    'engine' => '3.0L Turbo',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 2,
                    'color' => 'Red',
                ],[
                    'id' => 2,
                    'name' => 'Honda Civic Type R',
                    'image_url' => asset('images/cars/civic.jpg'),
                    'rating' => 4.7,
                    'reviews' => 98,
                    'is_best_seller' => true,
                    'price' => 38000,
                    'engine' => '2.0L Turbo',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Manual',
                    'seats' => 4,
                    'color' => 'Blue',
                ],[
                    'id' => 3,
                    'name' => 'BMW 320i',
                    'image_url' => asset('images/cars/bmw-320i.jpg'),
                    'rating' => 4.9,
                    'reviews' => 99,
                    'is_best_seller' => true,
                    'price' => 55000,
                    'engine' => '2.0L TwinPower Turbo',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 5,
                    'color' => 'Black',
                ],[
                    'id' => 4,
                    'name' => 'VinFast Lux A2.0',
                    'image_url' => asset('images/cars/vinfast-lux-a20.jpg'),
                    'rating' => 4.6,
                    'reviews' => 85,
                    'is_best_seller' => true,
                    'price' => 39000,
                    'engine' => '2.0L Turbo',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 5,
                    'color' => 'Gray',
                ],[
                    'id' => 5,
                    'name' => 'Hyundai Tucson',
                    'image_url' => asset('images/cars/tucson.jpg'),
                    'rating' => 4.8,
                    'reviews' => 90,
                    'is_best_seller' => false,
                    'price' => 34000,
                    'engine' => '2.0L MPI',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 5,
                    'color' => 'White',
                ],[
                    'id' => 6,
                    'name' => 'Ford Ranger',
                    'image_url' => asset('images/cars/ranger.jpg'),
                    'rating' => 4.9,
                    'reviews' => 134,
                    'is_best_seller' => true,
                    'price' => 42000,
                    'engine' => '2.2L Diesel',
                    'fuel_type' => 'Diesel',
                    'transmission' => 'Manual',
                    'seats' => 5,
                    'color' => 'Silver',
                ],[
                    'id' => 7,
                    'name' => 'Mazda CX-5',
                    'image_url' => asset('images/cars/cx5.jpg'),
                    'rating' => 4.7,
                    'reviews' => 95,
                    'is_best_seller' => false,
                    'price' => 37000,
                    'engine' => '2.5L SkyActiv',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 5,
                    'color' => 'Brown',
                ],[
                    'id' => 8,
                    'name' => 'Mercedes C-Class',
                    'image_url' => asset('images/cars/mercedes-c.jpg'),
                    'rating' => 4.9,
                    'reviews' => 88,
                    'is_best_seller' => false,
                    'price' => 60000,
                    'engine' => '2.0L Turbo',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 5,
                    'color' => 'Black',
                ],[
                    'id' => 9,
                    'name' => 'Kia Seltos',
                    'image_url' => asset('images/cars/seltos.jpg'),
                    'rating' => 4.7,
                    'reviews' => 75,
                    'is_best_seller' => false,
                    'price' => 30000,
                    'engine' => '1.6L Turbo',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'CVT',
                    'seats' => 5,
                    'color' => 'Orange',
                ],[
                    'id' => 10,
                    'name' => 'Mitsubishi Xpander',
                    'image_url' => asset('images/cars/xpander.jpg'),
                    'rating' => 4.8,
                    'reviews' => 110,
                    'is_best_seller' => false,
                    'price' => 32000,
                    'engine' => '1.5L MIVEC',
                    'fuel_type' => 'Petrol',
                    'transmission' => 'Automatic',
                    'seats' => 7,
                    'color' => 'Silver',
                ],];}else {
                    $featuredCars = Car::where('is_featured', true)
                        ->with('engine')
                        ->take(4)
                        ->get();
                }
        $banners = Banner::where('is_active', true)
            ->orderBy('position')
            ->with('car')
            ->get();
       
        // Log banner information for debugging
        \Illuminate\Support\Facades\Log::info('Banners retrieved for home page', [
            'count' => $banners->count(),
            'banner_data' => $banners->map(function($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'video_url' => $banner->video_url
                ];
            })
        ]);

        // Ensure banners have correct video URLs and log verification process
        foreach ($banners as $banner) {
            if (!$banner->video_url) {
                \Illuminate\Support\Facades\Log::warning('Banner has no video URL', ['banner_id' => $banner->id]);
                // If video URL is empty, set default
                $banner->video_url = 'videos/video1.mp4';
            } else {
                // Check if the file exists in storage
                $storagePath = storage_path('app/public/' . $banner->video_url);
                $publicPath = public_path('storage/' . $banner->video_url);

                \Illuminate\Support\Facades\Log::info('Checking banner video paths', [
                    'banner_id' => $banner->id,
                    'video_url' => $banner->video_url,
                    'storage_path' => $storagePath,
                    'public_path' => $publicPath,
                    'storage_exists' => file_exists($storagePath),
                    'public_exists' => file_exists($publicPath)
                ]);

                if (!file_exists($storagePath) && !file_exists($publicPath)) {
                    \Illuminate\Support\Facades\Log::warning('Banner video file not found', [
                        'banner_id' => $banner->id,
                        'video_url' => $banner->video_url
                    ]);

                    // If file doesn't exist in storage, set default
                    $banner->video_url = 'videos/video1.mp4';
                }
            }
        }

        return view('home', compact('banners', 'featuredCars'));
    }

    public function about() {
        return view('about');
    }

    public function cars() {
        $cars = Car::all();
        return view('cars', compact('cars'));
    }

    public function carDetail($id) {
        $car = Car::findOrFail($id);
        return view('car-detail', compact('car'));
    }

    public function buyForm($id = null) {
        $carDetails = CarDetail::with(['car', 'color'])->get();
        return view('buy', compact('carDetails'));
    }

    public function contact() {
        return view('contact');
    }

    public function search(Request $request) {
    $query = $request->get('q');
    $cars = Car::where('name', 'LIKE', "%$query%")
                ->orWhere('brand', 'LIKE', "%$query%")
                ->get(['id', 'name', 'brand', 'image_url']);
    return response()->json($cars);
    }

    public function featuredCars() {
        $cars = Car::where('is_featured', 1)->paginate(10);
        return view('featured-cars', compact('cars'));
    }
}
