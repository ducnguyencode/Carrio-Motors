<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarDetail;
use App\Models\Banner;
use App\Models\Make;

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
}
