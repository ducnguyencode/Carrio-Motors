<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get content admin user
        $contentAdmin = User::where('role', 'content')->first();

        // If no content admin found, use the first admin
        if (!$contentAdmin) {
            $contentAdmin = User::where('role', 'admin')->first();
        }

        if (!$contentAdmin) {
            $this->command->info('No admin/content user found, skipping blog posts seeding.');
            return;
        }

        $blogPosts = [
            [
                'title' => 'Top 10 Electric Cars You Should Consider in 2023',
                'excerpt' => 'Electric cars are becoming more popular than ever. Here are our top picks for 2023, with analysis of range, performance, and value.',
                'content' => '<h2>The Rise of Electric Vehicles</h2>
<p>The automotive industry is rapidly transitioning to electric power, with more options than ever before available to consumers. From affordable commuter EVs to high-performance luxury models, there\'s now an electric car for every need and budget.</p>

<h3>1. Tesla Model 3</h3>
<p>The Tesla Model 3 continues to dominate the electric vehicle market with its impressive range of up to 358 miles, cutting-edge technology, and strong performance credentials. The Model 3 starts at around $40,000 for the base model.</p>

<h3>2. Ford Mustang Mach-E</h3>
<p>Ford\'s electric Mustang offers a blend of performance and practicality with a range of up to 305 miles. Its stylish design and driver-focused features make it a compelling option for those looking to go electric.</p>

<h3>3. Hyundai Ioniq 5</h3>
<p>With its retro-futuristic design and ultra-fast charging capabilities, the Ioniq 5 has quickly become a favorite among EV enthusiasts. It can charge from 10% to 80% in just 18 minutes with a suitable fast charger.</p>

<h3>4. Kia EV6</h3>
<p>Sharing a platform with the Ioniq 5, the Kia EV6 offers sporty handling and impressive performance, particularly in the GT version which can accelerate from 0-60 mph in just 3.5 seconds.</p>

<h3>5. Volkswagen ID.4</h3>
<p>The ID.4 combines German engineering with electric efficiency in an SUV package. With a range of up to 275 miles and a spacious interior, it\'s perfect for families making the switch to electric.</p>

<h3>Conclusion</h3>
<p>Electric vehicles have come a long way in recent years, and the options available today offer compelling alternatives to traditional gasoline-powered cars. With charging infrastructure expanding and battery technology improving, there\'s never been a better time to consider an electric vehicle.</p>',
                'category' => 'Electric Vehicles',
                'tags' => ['Electric', 'Tesla', 'Ford', 'Hyundai', 'Kia', 'Volkswagen'],
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Essential Car Maintenance Tips Every Owner Should Know',
                'excerpt' => 'Regular maintenance is key to keeping your vehicle running smoothly. Learn the essential maintenance tasks you should perform to extend your car\'s lifespan.',
                'content' => '<h2>Why Regular Maintenance Matters</h2>
<p>Regular maintenance is vital for keeping your vehicle in optimal condition, preventing costly repairs, and ensuring safety on the road. By following these simple maintenance tips, you can extend the life of your car and maintain its value.</p>

<h3>1. Oil Changes</h3>
<p>One of the most important maintenance tasks is changing your oil regularly. Modern engines typically need oil changes every 5,000 to 10,000 miles, but always check your owner\'s manual for the recommended interval for your specific vehicle.</p>

<h3>2. Tire Maintenance</h3>
<p>Proper tire maintenance includes regular pressure checks, rotation, and alignment. Check your tire pressure at least once a month and before long trips. Rotate your tires every 5,000 to 8,000 miles to ensure even wear.</p>

<h3>3. Brake System</h3>
<p>Have your brakes inspected regularly, typically during tire rotations. Listen for any unusual noises like grinding or squealing, which could indicate worn brake pads or other issues that need immediate attention.</p>

<h3>4. Battery Care</h3>
<p>Modern batteries require little maintenance, but you should regularly check for corrosion on the terminals and ensure the battery is securely mounted. Most car batteries last 3-5 years, so be prepared to replace yours when it reaches this age.</p>

<h3>5. Fluid Levels</h3>
<p>Regularly check all fluid levels, including coolant, power steering fluid, brake fluid, and transmission fluid. Low levels can indicate leaks or other problems that should be addressed promptly.</p>

<h3>Conclusion</h3>
<p>Being proactive about car maintenance not only saves you money in the long run but also ensures your vehicle remains safe and reliable. Establish a regular maintenance schedule based on your owner\'s manual and stick to it for the best results.</p>',
                'category' => 'Maintenance',
                'tags' => ['Maintenance', 'Tips', 'Car Care', 'DIY'],
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'The Future of Autonomous Driving: Where We Are and Where We\'re Heading',
                'excerpt' => 'Autonomous driving technology is evolving rapidly. Learn about the current state of self-driving cars and what the future holds.',
                'content' => '<h2>The Road to Self-Driving Cars</h2>
<p>Autonomous driving technology has made tremendous strides in recent years, with various levels of self-driving capabilities already available in consumer vehicles. But where exactly are we on the path to fully autonomous vehicles, and what challenges remain?</p>

<h3>The Six Levels of Autonomy</h3>
<p>The Society of Automotive Engineers (SAE) defines six levels of driving automation, from Level 0 (fully manual) to Level 5 (fully autonomous). Most consumer vehicles with driver assistance features today operate at Level 1 or 2, providing functions like adaptive cruise control and lane-keeping assistance.</p>

<h3>Current Technology in the Market</h3>
<p>Several automakers and technology companies are pushing the boundaries of autonomous driving technology:</p>
<ul>
<li>Tesla\'s Autopilot and Full Self-Driving (FSD) systems represent some of the most widely deployed autonomous features, though they still require driver attention.</li>
<li>Waymo, Google\'s self-driving car project, has been operating autonomous taxis in Phoenix, Arizona, demonstrating Level 4 capabilities in controlled areas.</li>
<li>GM\'s Super Cruise and Ford\'s BlueCruise offer hands-free driving on mapped highways, with driver monitoring systems ensuring attention is maintained.</li>
</ul>

<h3>Challenges and Hurdles</h3>
<p>Despite significant progress, several challenges remain before fully autonomous vehicles become mainstream:</p>
<ul>
<li>Technical challenges including handling extreme weather, construction zones, and unpredictable human behavior</li>
<li>Regulatory frameworks that vary by region and are still evolving</li>
<li>Ethical questions about decision-making in unavoidable accident scenarios</li>
<li>Consumer trust and acceptance of the technology</li>
</ul>

<h3>The Future Outlook</h3>
<p>Experts predict that fully autonomous vehicles will be deployed gradually, likely beginning with restricted operational domains such as highway driving or low-speed urban environments. The timeline for widespread Level 5 autonomy remains uncertain, with estimates ranging from 5 to 20 years.</p>

<h3>Conclusion</h3>
<p>Autonomous driving technology continues to advance rapidly, promising to revolutionize transportation by making it safer, more efficient, and more accessible. While full autonomy may still be years away, the incremental improvements we\'re seeing today are already changing how we think about cars and mobility.</p>',
                'category' => 'Technology',
                'tags' => ['Autonomous', 'Self-Driving', 'Technology', 'Future', 'Tesla', 'Waymo'],
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Choosing the Right Family SUV: A Comprehensive Guide',
                'excerpt' => 'Finding the perfect family SUV involves considering safety, space, fuel efficiency, and features. This guide will help you navigate the options.',
                'content' => '<h2>What to Look for in a Family SUV</h2>
<p>Choosing the right SUV for your family can be overwhelming given the numerous options available today. This guide will help you focus on the most important factors to consider when making this significant purchase.</p>

<h3>Safety Features</h3>
<p>Safety should be your top priority when selecting a family vehicle. Look for SUVs with high crash test ratings from the IIHS and NHTSA, as well as advanced safety features such as:</p>
<ul>
<li>Automatic Emergency Braking (AEB)</li>
<li>Blind Spot Monitoring</li>
<li>Lane Departure Warning and Lane Keeping Assist</li>
<li>Rear Cross-Traffic Alert</li>
<li>360-degree camera systems</li>
</ul>

<h3>Space and Comfort</h3>
<p>Consider your family\'s specific needs for passenger and cargo space:</p>
<ul>
<li>How many seats do you need? Two-row SUVs typically seat five, while three-row models can accommodate seven or eight passengers.</li>
<li>Is the third row comfortable for adults or only suitable for children?</li>
<li>How much cargo space is available, both with all seats in use and with seats folded?</li>
<li>Are there enough LATCH anchors for car seats if you have young children?</li>
</ul>

<h3>Fuel Efficiency and Powertrain Options</h3>
<p>Modern family SUVs come with various powertrain options, each with its own benefits:</p>
<ul>
<li>Traditional gasoline engines: Still the most common and offer a balance of power and efficiency</li>
<li>Hybrid models: Offer significantly better fuel economy, especially in city driving</li>
<li>Plug-in hybrids: Can travel short distances on electricity alone before using gasoline</li>
<li>Full electric SUVs: Zero emissions and lowest operating costs, but require charging infrastructure</li>
</ul>

<h3>Technology and Convenience Features</h3>
<p>Family-friendly technology can make a big difference in day-to-day usability:</p>
<ul>
<li>Infotainment systems with Apple CarPlay and Android Auto</li>
<li>Rear seat entertainment systems</li>
<li>Multiple USB ports and power outlets</li>
<li>Hands-free liftgate for easy access when your hands are full</li>
<li>Driver memory settings if multiple family members share driving duties</li>
</ul>

<h3>Top Family SUV Recommendations for 2023</h3>
<p>Based on the criteria above, here are some standout options to consider:</p>
<ul>
<li>Toyota Highlander: Excellent reliability and available as a hybrid</li>
<li>Kia Telluride: Spacious three-row SUV with premium features at a reasonable price</li>
<li>Honda CR-V: Perfect midsize option with excellent safety ratings and fuel economy</li>
<li>Subaru Outback: Ideal for families who need all-weather capability</li>
<li>Hyundai Palisade: Upscale interior and comprehensive safety features</li>
</ul>

<h3>Conclusion</h3>
<p>The perfect family SUV balances safety, space, efficiency, and features that make daily life easier. Take your time test driving different models, and bring the whole family along to ensure everyone\'s needs are met before making your final decision.</p>',
                'category' => 'Family',
                'tags' => ['Family', 'SUV', 'Safety', 'Toyota', 'Honda', 'Kia', 'Hyundai', 'Subaru'],
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Upcoming Car Models to Watch in 2024',
                'excerpt' => 'The automotive industry never stands still. Here\'s a preview of the most anticipated new car models coming in 2024.',
                'content' => '<h2>Exciting New Vehicles Coming Soon</h2>
<p>The automotive industry continues to evolve at a rapid pace, with manufacturers unveiling innovative new models each year. Here\'s a look at some of the most anticipated vehicles set to debut in 2024.</p>

<h3>Electric Vehicles Taking Center Stage</h3>
<p>Electric vehicles will dominate new releases in 2024, with nearly every major manufacturer introducing new EV models:</p>
<ul>
<li><strong>Tesla Cybertruck:</strong> After multiple delays, Tesla\'s futuristic electric pickup is finally expected to reach volume production in 2024.</li>
<li><strong>Chevrolet Equinox EV:</strong> GM\'s affordable electric SUV aims to bring EV technology to the masses with a starting price around $30,000.</li>
<li><strong>Audi A6 e-tron:</strong> Audi\'s electric sedan will feature the new PPE platform developed jointly with Porsche, promising exceptional range and performance.</li>
</ul>

<h3>Performance Cars</h3>
<p>For enthusiasts, several exciting performance models are on the horizon:</p>
<ul>
<li><strong>Ford Mustang Dark Horse:</strong> The most powerful naturally aspirated 5.0 V8 Mustang ever, with track-focused capabilities.</li>
<li><strong>Toyota GR Corolla MORIZO Edition:</strong> A limited-edition, lightweight version of the already impressive GR Corolla.</li>
<li><strong>BMW M5:</strong> The next generation of BMW\'s legendary performance sedan will feature a hybrid powertrain with over 700 horsepower.</li>
</ul>

<h3>Luxury Vehicles</h3>
<p>The luxury segment will see several significant new entries:</p>
<ul>
<li><strong>Mercedes-Benz EQS SUV:</strong> An SUV version of the flagship EQS electric sedan, offering three rows of seating and cutting-edge technology.</li>
<li><strong>Cadillac Celestiq:</strong> A hand-built, ultra-luxury electric flagship sedan with a price tag approaching $300,000.</li>
<li><strong>Range Rover Electric:</strong> The first fully electric version of the iconic luxury SUV.</li>
</ul>

<h3>SUVs and Crossovers</h3>
<p>The popular SUV segment continues to grow with these upcoming models:</p>
<ul>
<li><strong>Honda CR-V Hybrid:</strong> A new generation of Honda\'s popular compact SUV with improved hybrid efficiency.</li>
<li><strong>Jeep Recon:</strong> An all-new electric SUV inspired by the Wrangler, focused on off-road capability.</li>
<li><strong>Kia EV9:</strong> A three-row electric SUV based on the same platform as the successful EV6.</li>
</ul>

<h3>Trucks and Vans</h3>
<p>The truck market will see important new entries:</p>
<ul>
<li><strong>Toyota Tacoma:</strong> A complete redesign of Toyota\'s midsize pickup, expected to offer hybrid powertrains.</li>
<li><strong>RAM 1500 REV:</strong> RAM\'s answer to the Ford F-150 Lightning, an all-electric full-size pickup.</li>
</ul>

<h3>Conclusion</h3>
<p>2024 promises to be an exciting year for new vehicle releases, with a strong emphasis on electrification across all segments. Whether you\'re looking for practicality, performance, or luxury, there will be compelling new options to consider in the coming year.</p>',
                'category' => 'News',
                'tags' => ['2024', 'New Models', 'Future', 'Electric', 'Hybrid', 'Tesla', 'Ford', 'Toyota'],
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Understanding Hybrid vs Plug-in Hybrid vs Full Electric: Which Is Right For You?',
                'excerpt' => 'With so many electrified options available, choosing between hybrid, plug-in hybrid, and fully electric vehicles can be confusing. We break down the differences to help you decide.',
                'content' => '<h2>Electrified Vehicles Explained</h2>
<p>As the automotive industry continues to embrace electrification, consumers now have more choices than ever when it comes to vehicles with electric powertrains. Understanding the differences between hybrid, plug-in hybrid, and fully electric vehicles is crucial for making an informed decision.</p>

<h3>Conventional Hybrids (HEV)</h3>
<p>Conventional hybrids combine a gasoline engine with an electric motor and a small battery. The battery is charged through regenerative braking, not by plugging in. These vehicles offer better fuel economy than traditional gasoline vehicles but have limited electric-only driving capability.</p>

<h3>Plug-in Hybrids (PHEV)</h3>
<p>Plug-in hybrids also use both a gasoline engine and an electric motor, but they have larger batteries that can be charged by plugging into an external power source. PHEVs can typically travel 20-50 miles on electricity alone before the gasoline engine kicks in, making them ideal for drivers who want electric capability for daily commutes but need gas power for longer trips.</p>

<h3>Battery Electric Vehicles (BEV)</h3>
<p>Battery electric vehicles run solely on electricity and have no gasoline engine. They produce zero tailpipe emissions and generally offer lower operating costs than gas-powered vehicles. Modern BEVs offer ranges from 200 to over 400 miles on a single charge, though they require access to charging infrastructure.</p>',
                'status' => 'draft',
                'tags' => ['Hybrid', 'Electric', 'Plug-in', 'Comparison', 'Technology'],
                'category' => 'Technology',
            ],
        ];

        foreach ($blogPosts as $postData) {
            // Generate slug from title
            $slug = Str::slug($postData['title']);

            // Create the blog post
            BlogPost::create([
                'user_id' => $contentAdmin->id,
                'title' => $postData['title'],
                'slug' => $slug,
                'excerpt' => $postData['excerpt'] ?? null,
                'content' => $postData['content'] ?? null,
                'featured_image' => null, // Would need real images
                'category' => $postData['category'] ?? null,
                'tags' => $postData['tags'] ?? null,
                'status' => $postData['status'],
                'published_at' => $postData['published_at'] ?? null,
            ]);
        }

        $this->command->info('Blog posts seeded successfully!');
    }
}
