<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarDetail;
use App\Models\Banner;
use App\Models\Make;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Engine;
use App\Models\SocialMediaLink;

class PageController extends Controller
{
    public function home() {
        // Get date range for last week
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        // Initialize bestSellingCars as an empty collection
        $bestSellingCars = collect();

        // Try to get best selling cars, handle any database errors
        try {
            // Get best selling cars from all completed invoices, not just last week
            $bestSellingCars = InvoiceDetail::select(
                'cars_details.car_id',
                DB::raw('SUM(invoice_details.quantity) as total_sold')
            )
            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->join('cars_details', 'invoice_details.car_detail_id', '=', 'cars_details.id')
            ->where('invoices.status', Invoice::STATUS_DONE)
            ->groupBy('cars_details.car_id')
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get();

            // Log the best selling cars for debugging
            \Illuminate\Support\Facades\Log::info('Best selling cars found', [
                'count' => $bestSellingCars->count(),
                'cars' => $bestSellingCars->toArray()
            ]);

            // Extract just the car IDs
            $bestSellingCarIds = $bestSellingCars->pluck('car_id');
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Error fetching best selling cars: ' . $e->getMessage());

            // Set to empty collection if error occurs
            $bestSellingCarIds = collect();
        }

        // Get the featured cars based on best sellers
        if ($bestSellingCarIds->count() > 0) {
            $featuredCars = Car::whereIn('id', $bestSellingCarIds)
                ->with(['engine', 'model.make', 'carDetails.carColor'])
                ->get();

            // Sort the cars in the same order as the best sellers list
            $featuredCars = $featuredCars->sortBy(function($car) use ($bestSellingCarIds) {
                return array_search($car->id, $bestSellingCarIds->toArray());
            });

            $featuredCars = $featuredCars->map(function($car) {
                // Get the car details with the highest quantity
                $bestDetail = $car->carDetails->sortByDesc('quantity')->first();

                // Get the color from car detail
                $color = $bestDetail && $bestDetail->carColor ? $bestDetail->carColor->name : 'N/A';

                // Use the price from the best car detail
                $price = $bestDetail ? $bestDetail->price : 0;

                return [
                    'id' => $car->id,
                    'name' => $car->name,
                    'image_url' => asset($car->main_image ? 'storage/'.$car->main_image : 'images/cars/default.jpg'),
                    'rating' => $car->rating ?? 4.5, // Use actual rating if available
                    'reviews' => $car->reviews_count ?? 100, // Use actual review count if available
                    'is_best_seller' => true,
                    'price' => $price,
                    'engine' => $car->engine ? $car->engine->name : 'N/A',
                    'fuel_type' => $car->engine ? $car->engine->fuel_type : 'N/A',
                    'transmission' => $car->transmission ?: 'N/A',
                    'seats' => $car->seat_number ?: 'N/A',
                    'color' => $color,
                ];
            })
            ->toArray();
        } else {
            // Fallback to featured cars if no sales data available
            $featuredCars = Car::where('is_featured', true)
                ->with(['engine', 'model.make', 'carDetails.carColor'])
                ->take(4)
                ->get();

            // If still no cars found, use active cars from car details
            if ($featuredCars->count() == 0) {
                $carDetails = CarDetail::where('quantity', '>', 0)
                    ->with(['car.engine', 'car.model.make', 'carColor'])
                    ->orderBy('price', 'desc')
                    ->take(4)
                    ->get();

                if ($carDetails->count() > 0) {
                    $featuredCars = $carDetails->map(function($detail) {
                        $car = $detail->car;
                        return [
                            'id' => $car->id,
                            'name' => $car->name,
                            'image_url' => asset($car->main_image ? 'storage/'.$car->main_image : 'images/cars/default.jpg'),
                            'rating' => $car->rating ?? 4.5, // Use actual rating if available
                            'reviews' => $car->reviews_count ?? 100, // Use actual review count if available
                            'is_best_seller' => false,
                            'price' => $detail->price,
                            'engine' => $car->engine ? $car->engine->name : 'N/A',
                            'fuel_type' => $car->engine ? $car->engine->fuel_type : 'N/A',
                            'transmission' => $car->transmission ?: 'N/A',
                            'seats' => $car->seat_number ?: 'N/A',
                            'color' => $detail->carColor ? $detail->carColor->name : 'N/A',
                        ];
                    })->toArray();
                } else {
                    // Last resort: use mock data
                    $featuredCars = $this->getMockFeaturedCars();
                }
            } else {
                $featuredCars = $featuredCars->map(function($car) {
                    // Get the car details with the highest quantity
                    $bestDetail = $car->carDetails->sortByDesc('quantity')->first();

                    // Get the color from car detail
                    $color = $bestDetail && $bestDetail->carColor ? $bestDetail->carColor->name : 'N/A';

                    // Use the price from the best car detail
                    $price = $bestDetail ? $bestDetail->price : 0;

                    return [
                        'id' => $car->id,
                        'name' => $car->name,
                        'image_url' => asset($car->main_image ? 'storage/'.$car->main_image : 'images/cars/default.jpg'),
                        'rating' => $car->rating ?? 4.5, // Use actual rating if available
                        'reviews' => $car->reviews_count ?? 100, // Use actual review count if available
                        'is_best_seller' => false,
                        'price' => $price,
                        'engine' => $car->engine ? $car->engine->name : 'N/A',
                        'fuel_type' => $car->engine ? $car->engine->fuel_type : 'N/A',
                        'transmission' => $car->transmission ?: 'N/A',
                        'seats' => $car->seat_number ?: 'N/A',
                        'color' => $color,
                    ];
                })
                ->toArray();
            }
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

        return view('home', compact('featuredCars', 'banners'));
    }

    /**
     * Get mock data for featured cars when no data is available
     * @return array
     */
    private function getMockFeaturedCars()
    {
        return [
            [
                'id' => 1,
                'name' => 'V8 New',
                'image_url' => asset('images/cars/default.jpg'),
                'rating' => 4.8,
                'reviews' => 100,
                'is_best_seller' => true,
                'price' => 75000,
                'engine' => 'Electric',
                'fuel_type' => 'Electric',
                'transmission' => 'Automatic',
                'seats' => 2,
                'color' => 'Orange',
            ],
            [
                'id' => 2,
                'name' => 'Model S',
                'image_url' => asset('images/cars/default.jpg'),
                'rating' => 4.8,
                'reviews' => 100,
                'is_best_seller' => true,
                'price' => 85000,
                'engine' => 'V8 Gasoline',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seats' => 4,
                'color' => 'Yellow',
            ],
            [
                'id' => 3,
                'name' => 'M850i Coupe',
                'image_url' => asset('images/cars/default.jpg'),
                'rating' => 4.9,
                'reviews' => 120,
                'is_best_seller' => true,
                'price' => 95000,
                'engine' => '4.4L Twin-Turbo V8',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seats' => 4,
                'color' => 'Black',
            ],
            [
                'id' => 4,
                'name' => 'AMG GT',
                'image_url' => asset('images/cars/default.jpg'),
                'rating' => 4.7,
                'reviews' => 95,
                'is_best_seller' => true,
                'price' => 118000,
                'engine' => '4.0L Biturbo V8',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seats' => 2,
                'color' => 'Silver',
            ],
        ];
    }

    public function about() {
        return view('about');
    }

    public function cars(Request $request) {
        // Base query
        $query = Car::with(['model.make', 'engine', 'carDetails.carColor'])
                ->where('isActive', true);

        // Apply price filter
        if ($request->has('min_price') && $request->min_price) {
            $minPrice = (float) $request->min_price;
            $query->whereHas('carDetails', function($q) use ($minPrice) {
                $q->where('price', '>=', $minPrice);
            });
        }

        if ($request->has('max_price') && $request->max_price) {
            $maxPrice = (float) $request->max_price;
            $query->whereHas('carDetails', function($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice);
            });
        }

        // Apply brand filter
        if ($request->has('brand') && $request->brand) {
            $brand = $request->brand;
            $query->whereHas('model.make', function($q) use ($brand) {
                $q->where('name', $brand);
            });
        }

        // Apply fuel type filter
        if ($request->has('fuel_type') && is_array($request->fuel_type)) {
            $fuelTypes = $request->fuel_type;
            $query->whereHas('engine', function($q) use ($fuelTypes) {
                $q->whereIn('engine_type', $fuelTypes);
            });
        }

        // Apply transmission filter
        if ($request->has('transmission') && $request->transmission) {
            $query->where('transmission', $request->transmission);
        }

        // Apply seats filter
        if ($request->has('seats') && is_array($request->seats)) {
            $query->where(function($q) use ($request) {
                foreach ($request->seats as $seatCount) {
                    if ($seatCount == '7') {
                        // For 7+ seats, look for cars with 7 or more seats
                        $q->orWhere('seat_number', '>=', 7);
                    } else {
                        $q->orWhere('seat_number', $seatCount);
                    }
                }
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'price-asc');

        // Simple approach to avoid SQL errors
        switch ($sortBy) {
            case 'price-desc':
                // Get all cars first
                $carsData = Car::where('isActive', true)->get();
                // Then sort by their cheapest price
                $sortedIds = $carsData->sortByDesc(function($car) {
                    $cheapestDetail = $car->carDetails->sortBy('price')->first();
                    return $cheapestDetail ? $cheapestDetail->price : PHP_INT_MAX;
                })->pluck('id')->toArray();
                // Use ordered ids to sort the query
                $query->whereIn('id', $sortedIds)
                      ->orderByRaw("FIELD(id, " . implode(',', $sortedIds) . ")");
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            case 'rating-desc':
                // Sort by rating (descending) then by reviews_count (descending)
                $carsData = Car::where('isActive', true)->get();

                // First, sort by rating, then by reviews_count
                $sortedIds = $carsData->sortByDesc(function($car) {
                    // Create a more balanced formula between rating and review count
                    // New formula: (rating * 10) + (reviews_count / 100)
                    // This still prioritizes rating as the most important factor
                    // but cars with more reviews will rank higher when ratings are close
                    return ($car->rating * 10) + ($car->reviews_count / 100);
                })->pluck('id')->toArray();

                // Apply the sort if we have results
                if (!empty($sortedIds)) {
                    $query->whereIn('id', $sortedIds)
                          ->orderByRaw("FIELD(id, " . implode(',', $sortedIds) . ")");
                } else {
                    // Fallback to database sorting if no cars
                    $query->orderBy('rating', 'desc')
                          ->orderBy('reviews_count', 'desc');
                }
                break;
            case 'price-asc':
            default:
                // Get all cars first
                $carsData = Car::where('isActive', true)->get();
                // Then sort by their cheapest price
                $sortedIds = $carsData->sortBy(function($car) {
                    $cheapestDetail = $car->carDetails->sortBy('price')->first();
                    return $cheapestDetail ? $cheapestDetail->price : PHP_INT_MAX;
                })->pluck('id')->toArray();

                if (empty($sortedIds)) {
                    $query->orderBy('id', 'asc'); // Fallback if no cars found
                } else {
                    // Use ordered ids to sort the query
                    $query->whereIn('id', $sortedIds)
                          ->orderByRaw("FIELD(id, " . implode(',', $sortedIds) . ")");
                }
                break;
        }

        // Get cars with pagination
        $cars = $query->paginate(9);

        // Load additional data for each car
        foreach ($cars as $car) {
            // Get the lowest price variant
            $car->cheapestDetail = $car->carDetails()->orderBy('price', 'asc')->first();

            // Get available colors with proper mapping
            $carDetails = $car->carDetails()->with('carColor')->get();
            $availableColors = collect();

            foreach($carDetails as $detail) {
                if ($detail->carColor && !$availableColors->contains('id', $detail->carColor->id)) {
                    $availableColors->push($detail->carColor);
                }
            }

            $car->availableColors = $availableColors;
        }

        // Get all brands for filter dropdown
        $brands = Make::orderBy('name')->get();

        // Get fuel types from engine table or use default values if the column doesn't exist
        try {
            $fuelTypes = Engine::select('engine_type')->distinct()->pluck('engine_type');

            // If no engine types found, use default values
            if ($fuelTypes->isEmpty()) {
                $fuelTypes = collect(['Petrol', 'Diesel', 'Hybrid', 'Electric']);
            }
        } catch (\Exception $e) {
            // Fallback to default values if there's an error
            $fuelTypes = collect(['Petrol', 'Diesel', 'Hybrid', 'Electric']);
        }
        return view('cars', compact('cars', 'brands', 'fuelTypes'));
    }

    public function carDetail($id) {
        // Load the car with all relationships needed for display
        $car = Car::with([
            'carDetails.carColor',
            'engine',
            'model.make'
        ])->findOrFail($id);

        // Load active social media links
        $socialLinks = SocialMediaLink::active()->ordered()->where('show_on_car_detail', true)->get();

        // For debugging - log the car details to see what variants are available
        \Illuminate\Support\Facades\Log::info('Car Details for ID: ' . $id, [
            'total_details' => $car->carDetails->count(),
            'details' => $car->carDetails->map(function($detail) {
                return [
                    'id' => $detail->id,
                    'color' => $detail->carColor ? $detail->carColor->name : 'None',
                    'price' => $detail->price,
                    'quantity' => $detail->quantity
                ];
            })
        ]);

        // Ensure all details are loaded and sorted by price
        if ($car->carDetails && $car->carDetails->count() > 0) {
            $car->carDetails = $car->carDetails->sortBy('price');

            // If car price is not set, use the price from first variant
            if (!$car->price) {
                $car->price = $car->carDetails->first()->price ?? 0;
            }
        }

        // Fetch similar cars: same make, exclude current
        $makeId = $car->model->make_id ?? null;
        $similarCars = collect();
        if ($makeId) {
            $similarCars = Car::with(['engine','model.make','carDetails.carColor'])
                ->whereHas('model', function($q) use ($makeId) {
                    $q->where('make_id', $makeId);
                })
                ->where('id', '!=', $car->id)
                ->take(4)
                ->get();
        }
        return view('cars_detail', compact('car', 'socialLinks', 'similarCars'));
    }

    public function buyForm($id = null) {
        $carDetails = CarDetail::with(['car', 'carColor'])->get();
        return view('buy', compact('carDetails'));
    }

    public function contact() {
        return view('contact');
    }

    public function search(Request $request) {
        $query = $request->get('q');
        $cars = Car::where('name', 'LIKE', "%$query%")
                    ->orWhereHas('model.make', function($q) use ($query) {
                        $q->where('name', 'LIKE', "%$query%");
                    })
                    ->with(['model.make'])
                    ->take(10)
                    ->get();

        return response()->json($cars->map(function($car) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'brand' => $car->model->make->name ?? 'Unknown',
                'image_url' => $car->main_image ? asset('storage/' . $car->main_image) : asset('images/cars/default.jpg')
            ];
        }));
    }

    public function featuredCars() {
        $cars = Car::where('is_featured', 1)->paginate(10);
        return view('featured-cars', compact('cars'));
    }

    public function brandCatalog() {
        // Get featured brands
        $featuredBrands = Make::where('is_featured', 1)
            ->get();

        // Get all brands organized by first letter
        $brands = Make::all();

        $brandsByLetter = [];
        foreach ($brands as $brand) {
            $firstLetter = strtoupper(substr($brand->name, 0, 1));
            if (!isset($brandsByLetter[$firstLetter])) {
                $brandsByLetter[$firstLetter] = [];
            }
            $brandsByLetter[$firstLetter][] = $brand;
        }

        // Sort each letter's brands alphabetically
        foreach ($brandsByLetter as $letter => $letterBrands) {
            usort($brandsByLetter[$letter], function($a, $b) {
                return strcmp($a->name, $b->name);
            });
        }

        return view('brand_catalog', compact('featuredBrands', 'brandsByLetter'));
    }

    public function brandDetail($slug) {
        $brand = Make::where('slug', $slug)
            ->firstOrFail();

        $cars = Car::where('make_id', $brand->id)
            ->orderBy('created_at', 'desc')
            ->with(['engine', 'model'])
            ->paginate(12);

        return view('brand_detail', compact('brand', 'cars'));
    }

    public function carComparison() {
        return view('car_comparison');
    }

        public function wishlist() {
        // We'll load the view without cars initially
        // as the cars will be loaded via JavaScript from localStorage
        return view('wishlist');
    }

    public function blog() {
        // In a real implementation, you would fetch blog posts from the database
        // For now, we'll use mock data
        $posts = [
            [
                'id' => 1,
                'slug' => 'top-10-electric-cars-2023',
                'title' => 'Top 10 Electric Cars of 2023',
                'excerpt' => 'Discover the best electric vehicles that are revolutionizing the automotive industry in 2023.',
                'image' => 'images/blog/electric-cars.jpg',
                'author' => 'Jane Smith',
                'date' => '2023-08-15',
                'category' => 'Electric Vehicles',
                'tags' => ['Electric', 'Tesla', 'Green Energy']
            ],
            [
                'id' => 2,
                'slug' => 'future-of-autonomous-driving',
                'title' => 'The Future of Autonomous Driving',
                'excerpt' => 'How self-driving technology is advancing and what to expect in the coming years.',
                'image' => 'images/blog/autonomous-driving.jpg',
                'author' => 'John Doe',
                'date' => '2023-07-28',
                'category' => 'Technology',
                'tags' => ['Autonomous', 'AI', 'Future Tech']
            ],
            [
                'id' => 3,
                'slug' => 'luxury-car-buying-guide',
                'title' => 'Ultimate Luxury Car Buying Guide',
                'excerpt' => 'Everything you need to know before investing in a high-end luxury vehicle.',
                'image' => 'images/blog/luxury-cars.jpg',
                'author' => 'Michael Johnson',
                'date' => '2023-07-10',
                'category' => 'Luxury Cars',
                'tags' => ['Luxury', 'Buying Guide', 'Investment']
            ],
            [
                'id' => 4,
                'slug' => 'car-maintenance-tips',
                'title' => 'Essential Car Maintenance Tips',
                'excerpt' => 'Simple maintenance steps every car owner should know to extend vehicle lifespan.',
                'image' => 'images/blog/car-maintenance.jpg',
                'author' => 'Sarah Williams',
                'date' => '2023-06-22',
                'category' => 'Maintenance',
                'tags' => ['DIY', 'Maintenance', 'Tips']
            ],
            [
                'id' => 5,
                'slug' => 'hybrid-vs-electric-comparison',
                'title' => 'Hybrid vs Electric: Which is Right for You?',
                'excerpt' => 'A comprehensive comparison to help you decide between hybrid and fully electric vehicles.',
                'image' => 'images/blog/hybrid-electric.jpg',
                'author' => 'David Chen',
                'date' => '2023-06-05',
                'category' => 'Comparisons',
                'tags' => ['Hybrid', 'Electric', 'Comparison']
            ],
            [
                'id' => 6,
                'slug' => 'best-family-cars-2023',
                'title' => 'Best Family Cars of 2023',
                'excerpt' => 'Top picks for spacious, safe, and comfortable vehicles perfect for family needs.',
                'image' => 'images/blog/family-cars.jpg',
                'author' => 'Emily Rodriguez',
                'date' => '2023-05-19',
                'category' => 'Family Vehicles',
                'tags' => ['Family', 'SUV', 'Safety']
            ]
        ];

        // Categories for sidebar
        $categories = [
            'Electric Vehicles' => 8,
            'Luxury Cars' => 12,
            'Technology' => 15,
            'Maintenance' => 9,
            'Family Vehicles' => 7,
            'Sports Cars' => 6,
            'Comparisons' => 5
        ];

        return view('blog', compact('posts', 'categories'));
    }

    public function blogPost($slug) {
        // In a real implementation, you would fetch the post from the database
        // For now, we'll use mock data
        $posts = [
            'top-10-electric-cars-2023' => [
                'title' => 'Top 10 Electric Cars of 2023',
                'image' => 'images/blog/electric-cars.jpg',
                'author' => 'Jane Smith',
                'date' => '2023-08-15',
                'category' => 'Electric Vehicles',
                'tags' => ['Electric', 'Tesla', 'Green Energy'],
                'content' => "<p>Electric vehicles (EVs) have revolutionized the automotive industry, offering environmentally-friendly alternatives to traditional combustion engines. As battery technology advances and charging infrastructure expands, electric cars are becoming increasingly practical for everyday use.</p>

                <p>Here are our top 10 picks for the best electric vehicles of 2023:</p>

                <h3>1. Tesla Model 3</h3>
                <p>The Tesla Model 3 continues to dominate the electric car market with its impressive range, cutting-edge technology, and sleek design. The 2023 model boasts improved battery efficiency and enhanced autopilot features.</p>

                <h3>2. Ford Mustang Mach-E</h3>
                <p>Ford's electric SUV combines the iconic Mustang heritage with modern electric technology. With a range of up to 300 miles and powerful performance, it's a compelling option for those seeking a sportier electric vehicle.</p>

                <h3>3. Hyundai Ioniq 5</h3>
                <p>With its retro-futuristic design and innovative platform, the Ioniq 5 offers fast charging capabilities and a spacious, tech-filled interior that redefines what an electric hatchback can be.</p>

                <h3>4. Kia EV6</h3>
                <p>Sharing its platform with the Ioniq 5, the Kia EV6 offers distinctive styling, impressive range, and lightning-fast charging that can take you from 10% to 80% in just 18 minutes.</p>

                <h3>5. Audi e-tron GT</h3>
                <p>For those seeking luxury in their electric vehicle, the Audi e-tron GT delivers with stunning design, powerful performance, and a refined interior that lives up to the premium Audi brand.</p>

                <h3>6. Rivian R1T</h3>
                <p>The first mainstream electric pickup truck, the Rivian R1T brings incredible capability, innovative storage solutions, and adventure-ready features that make it perfect for outdoor enthusiasts.</p>

                <h3>7. Mercedes EQS</h3>
                <p>The flagship electric sedan from Mercedes offers unparalleled luxury, a revolutionary MBUX Hyperscreen, and exceptional aerodynamics that contribute to its impressive range.</p>

                <h3>8. Polestar 2</h3>
                <p>This minimalist electric fastback from Volvo's performance spinoff brand delivers a unique Scandinavian design, Android Automotive OS integration, and engaging driving dynamics.</p>

                <h3>9. BMW iX</h3>
                <p>BMW's electric SUV flagship showcases the brand's future design direction and comes packed with innovative tech, sustainable materials, and impressive range and performance.</p>

                <h3>10. Volkswagen ID.4</h3>
                <p>This practical electric SUV offers a familiar driving experience, spacious interior, and solid range at a more accessible price point than many competitors.</p>

                <p>As electric vehicle technology continues to advance, we're seeing longer ranges, faster charging times, and more affordable options entering the market. Whether you're looking for luxury, performance, or practicality, there's now an electric vehicle to suit almost every need and budget.</p>

                <p>When considering an electric car purchase, be sure to factor in available charging infrastructure in your area, potential tax incentives, and your typical daily driving needs to find the perfect fit for your lifestyle.</p>"
            ],
            'future-of-autonomous-driving' => [
                'title' => 'The Future of Autonomous Driving',
                'image' => 'images/blog/autonomous-driving.jpg',
                'author' => 'John Doe',
                'date' => '2023-07-28',
                'category' => 'Technology',
                'tags' => ['Autonomous', 'AI', 'Future Tech'],
                'content' => "<p>Autonomous driving technology is rapidly evolving, promising to revolutionize transportation in ways we're only beginning to understand. From reducing accidents to transforming how we spend our time in vehicles, self-driving technology will reshape our relationship with cars.</p>

                <h3>Current State of Autonomous Technology</h3>
                <p>Today's autonomous vehicles typically operate on a scale of Level 0 (no automation) to Level 5 (full automation). Most advanced consumer vehicles on the market currently offer Level 2 or Level 3 automation, providing features like adaptive cruise control, lane-keeping assistance, and limited self-parking capabilities.</p>

                <p>Companies like Tesla, Waymo, and GM's Cruise are pushing the boundaries with more advanced systems, though fully autonomous Level 5 vehicles that can operate in all conditions without human intervention remain primarily in testing phases.</p>

                <h3>Technological Challenges</h3>
                <p>Several significant challenges remain before fully autonomous vehicles become mainstream:</p>
                <ul>
                    <li>Navigating unpredictable environments and extreme weather conditions</li>
                    <li>Interpreting complex social cues from pedestrians and other drivers</li>
                    <li>Developing ethical decision-making protocols for unavoidable accident scenarios</li>
                    <li>Creating robust cybersecurity measures to prevent hacking</li>
                    <li>Ensuring sensors and systems can operate reliably for thousands of hours</li>
                </ul>

                <h3>The Road to Full Autonomy</h3>
                <p>Most industry experts predict a gradual evolution rather than a sudden revolution in autonomous driving. We're likely to see increasingly sophisticated driver assistance systems before fully autonomous vehicles become commonplace.</p>

                <p>Urban areas with well-mapped roads and predictable traffic patterns will likely see the first fully autonomous services, primarily in the form of robotaxis and delivery vehicles operating in limited geographic areas.</p>

                <h3>Transformative Impacts</h3>
                <p>When autonomous vehicles achieve mainstream adoption, we can expect profound changes:</p>

                <h4>Safety Improvements</h4>
                <p>With human error contributing to approximately 94% of serious crashes, autonomous systems have the potential to drastically reduce accident rates, potentially saving thousands of lives annually.</p>

                <h4>Economic Effects</h4>
                <p>The trucking and delivery industries will undergo significant transformation, potentially displacing millions of driving jobs while creating new roles in fleet management and remote supervision.</p>

                <h4>Urban Planning Revolution</h4>
                <p>Cities may reclaim vast areas currently dedicated to parking as shared autonomous vehicles remain in near-constant use. Traffic patterns will optimize as networked vehicles communicate with each other and infrastructure.</p>

                <h4>Vehicle Ownership Changes</h4>
                <p>Personal vehicle ownership may decline in favor of subscription-based mobility services, essentially providing \"transportation as a service.\"</p>

                <h3>Timeline for Adoption</h3>
                <p>While predictions vary widely, a reasonable timeline might look like:</p>
                <ul>
                    <li><strong>2023-2025:</strong> Advanced Level 3 systems become more common in premium vehicles</li>
                    <li><strong>2025-2030:</strong> Limited Level 4 autonomous services operate in specific geographic areas</li>
                    <li><strong>2030-2035:</strong> Level 4 autonomy becomes widespread in new vehicles</li>
                    <li><strong>Beyond 2035:</strong> Level 5 fully autonomous vehicles begin mainstream adoption</li>
                </ul>

                <p>The transition to autonomous vehicles represents one of the most significant technological shifts in transportation since the invention of the automobile itself. While the timeline may be uncertain, the direction is clear: autonomous driving will fundamentally change how we move people and goods in the coming decades.</p>"
            ]
        ];

        // Get post data or return 404 if not found
        if (!isset($posts[$slug])) {
            abort(404);
        }

        $post = $posts[$slug];

        // Recent posts for sidebar
        $recentPosts = [
            ['slug' => 'luxury-car-buying-guide', 'title' => 'Ultimate Luxury Car Buying Guide', 'date' => '2023-07-10'],
            ['slug' => 'car-maintenance-tips', 'title' => 'Essential Car Maintenance Tips', 'date' => '2023-06-22'],
            ['slug' => 'hybrid-vs-electric-comparison', 'title' => 'Hybrid vs Electric: Which is Right for You?', 'date' => '2023-06-05']
        ];

        return view('blog_post', compact('post', 'recentPosts'));
    }

    /**
     * Process the contact form submission and send email notification
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'accepted',
            // Add validation
            'car' => 'required_if:subject,Car Purchase|string|max:255',
            'quantity' => 'required_if:subject,Car Purchase|integer|min:1',
            'payment_method' => 'required_if:subject,Car Purchase|string|max:255',
        ]);

        try {
            // Tạo dữ liệu cho email
            $emailData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? 'Not provided',
                'subject' => $validated['subject'],
                'userMessage' => $validated['message'],
            ];

            // Thêm thông tin mua xe nếu chủ đề là Car Purchase
            if ($validated['subject'] === 'Car Purchase') {
                $emailData['car'] = $validated['car'];
                $emailData['quantity'] = $validated['quantity'];
                $emailData['payment_method'] = $validated['payment_method'];
                $emailData['is_purchase'] = true;
            }

            // Send email notification to admin
            \Illuminate\Support\Facades\Mail::send('emails.contact', $emailData, function ($message) use ($validated) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to(config('mail.from.address'), 'Carrio Motors Support');
                $message->subject('New Contact Form Submission: ' . $validated['subject']);
            });

            // Log success message
            \Illuminate\Support\Facades\Log::info('Contact form submitted', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'is_purchase' => $validated['subject'] === 'Car Purchase',
            ]);

            // Thêm logic xử lý đơn hàng nếu là Car Purchase
            if ($validated['subject'] === 'Car Purchase') {
                // Ghi log riêng cho đơn đặt hàng
                \Illuminate\Support\Facades\Log::info('Car purchase request', [
                    'car' => $validated['car'],
                    'quantity' => $validated['quantity'],
                    'payment_method' => $validated['payment_method'],
                ]);

                // Có thể thêm code để lưu vào database nếu cần
                // ...
            }

            // Redirect back with success message
            return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error('Failed to send contact email: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Sorry, there was a problem sending your message. Please try again later.')->withInput();
        }
    }
}
