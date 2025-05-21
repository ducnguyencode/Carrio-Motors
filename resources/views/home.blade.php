@extends('layouts.app')

@section('styles')
<style>
    /* Video carousel styles */
    .video-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        position: relative;
    }

    .video-link:hover .carousel-content {
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    }

    .carousel-slide {
        position: relative;
    }

    /* Modern hero section styles */
    .hero-section {
        padding: 80px 0;
        background-color: #f8f9fa;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background-color: #1e88e5;
        clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        background: linear-gradient(45deg, #1e88e5, #0d47a1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: #424242;
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    /* Featured cars section styles */
    .featured-cars {
        padding: 80px 0;
        background-color: #fff;
    }

    .section-title {
        position: relative;
        margin-bottom: 50px;
        text-align: center;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(45deg, #1e88e5, #0d47a1);
    }

    .section-title p {
        color: #616161;
        font-size: 1.2rem;
    }

    .car-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 100%;
        background-color: #fff;
    }

    .car-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .car-image {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .car-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    .car-card:hover .car-image img {
        transform: scale(1.1);
    }

    .best-seller-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(45deg, #43a047, #2e7d32);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .car-content {
        padding: 25px;
    }

    .car-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #212121;
    }

    .car-rating {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .car-rating span.rating {
        font-weight: 600;
        margin-right: 5px;
    }

    .car-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e88e5;
        margin-bottom: 15px;
    }

    .car-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .car-specs .spec {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .spec-engine {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .spec-fuel {
        background-color: #e0f2f1;
        color: #00695c;
    }

    .spec-transmission {
        background-color: #e3f2fd;
        color: #0d47a1;
    }

    .car-button {
        display: block;
        width: 100%;
        padding: 12px;
        text-align: center;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        background-color: #f5f5f5;
        color: #1e88e5;
        border: 2px solid #1e88e5;
    }

    .car-button:hover {
        background-color: #1e88e5;
        color: white;
    }

    /* Why choose us section */
    .why-choose-us {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    .feature-card {
        background-color: white;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        color: #1e88e5;
    }

    .feature-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #212121;
    }

    .feature-desc {
        color: #616161;
        line-height: 1.6;
    }

    /* Modern Footer Styles */
    .footer {
        background-color: #212121;
        color: #f5f5f5;
        padding-top: 80px;
    }

    .footer-top {
        padding-bottom: 40px;
    }

    .footer-logo {
        margin-bottom: 20px;
    }

    .footer-logo img {
        height: 50px;
    }

    .footer-text {
        color: #bdbdbd;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .social-links {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }

    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: rgba(255,255,255,0.1);
        border-radius: 50%;
        color: #f5f5f5;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background-color: #1e88e5;
        transform: translateY(-3px);
    }

    .footer-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 15px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #1e88e5;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 15px;
    }

    .footer-links a {
        color: #bdbdbd;
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        padding-left: 15px;
    }

    .footer-links a::before {
        content: '›';
        position: absolute;
        left: 0;
        color: #1e88e5;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #fff;
        padding-left: 20px;
    }

    .footer-links a:hover::before {
        left: 5px;
    }

    .contact-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-info li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        color: #bdbdbd;
    }

    .contact-info i {
        color: #1e88e5;
        margin-right: 15px;
        font-size: 1.2rem;
    }

    .footer-bottom {
        padding: 20px 0;
        border-top: 1px solid rgba(255,255,255,0.1);
        text-align: center;
    }

    .copyright {
        color: #9e9e9e;
    }
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success mt-4" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(count($banners) > 0)
<div class="video-carousel">
    @foreach($banners as $index => $banner)
    <div class="carousel-slide {{ $index == 0 ? 'active' : '' }}">
        <a href="{{ $banner->click_url ?? ($banner->car_id ? route('car.detail', $banner->car_id) : '#') }}" class="video-link">
            <video class="background-video" autoplay muted loop>
                <source src="{{ asset('storage/'.$banner->video_url) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="carousel-content">
                <h1>{{ $banner->title }}</h1>
                <p>{{ $banner->main_content }}</p>
            </div>
        </a>
    </div>
    @endforeach

    <div class="carousel-indicators">
        @foreach($banners as $index => $banner)
        <div class="dot {{ $index == 0 ? 'active' : '' }}"></div>
        @endforeach
    </div>
</div>
@endif

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Welcome to Carrio Motors</h1>
                <p class="hero-subtitle">Discover your dream car with unbeatable prices and premium quality. Explore top brands like BMW, Audi, Hyundai, JEEP, Suzuki, and more!</p>
                <a href="{{ route('cars') }}" class="btn btn-primary btn-lg">View All Cars</a>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/car_dealership_showroom.jpg') }}" class="img-fluid rounded shadow" alt="Car Banner">
            </div>
        </div>
    </div>
</section>

<!-- Featured Cars Section -->
<section class="featured-cars">
    <div class="container">
        <div class="section-title">
            <h2>Best Selling Cars</h2>
            <p>Our top selling cars from last week</p>
    </div>

        <div class="row g-4">
            @foreach($featuredCars as $car)
            <div class="col-md-6 col-lg-3">
                <div class="car-card" data-car-id="{{ $car['id'] }}" data-car-json="{{ json_encode($car) }}">
                    <div class="car-image">
                        @if($car['is_best_seller'])
                        <div class="best-seller-badge">Best Seller</div>
                        @endif
                        <img src="{{ $car['image_url'] }}" alt="{{ $car['name'] }}">
                    </div>
                    <div class="car-content">
                        <h3 class="car-title">{{ $car['name'] }}</h3>
                        <div class="car-rating">
                            <span class="rating">{{ $car['rating'] }}</span>
                            <span class="text-warning">
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="ms-1 text-muted">({{ $car['reviews'] }} reviews)</span>
                        </div>
                        <div class="car-price">${{ number_format($car['price']) }}</div>
                        <div class="car-specs">
                            <span class="spec spec-engine">{{ $car['engine'] }}</span>
                            <span class="spec spec-fuel">{{ $car['fuel_type'] }}</span>
                            <span class="spec spec-transmission">{{ $car['transmission'] }}</span>
                        </div>
                        <a href="/cars/{{ $car['id'] }}" class="car-button">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('cars') }}" class="btn btn-primary btn-lg">Show More Cars</a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-us">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose Us</h2>
            <p>Experience the Carrio Motors difference</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3 class="feature-title">Quality Assured</h3>
                    <p class="feature-desc">All our vehicles undergo rigorous quality checks to ensure premium condition.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="feature-title">Best Prices</h3>
                    <p class="feature-desc">We offer competitive pricing and flexible payment options to fit your budget.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-desc">Our dedicated customer service team is available around the clock.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3 class="feature-title">Easy Returns</h3>
                    <p class="feature-desc">Not satisfied? Take advantage of our 7-day return policy, no questions asked.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials py-5 bg-light">
    <div class="container">
        <div class="section-title">
            <h2>What Our Customers Say</h2>
            <p>Real experiences from satisfied clients</p>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/testimonials/testimonial-1.jpg') }}" class="rounded-circle me-3" width="60" height="60" alt="Customer">
                                <div>
                                    <h5 class="mb-0">Alex Johnson</h5>
                                    <small class="text-muted">BMW Owner</small>
                                </div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="card-text">"I couldn't be happier with my purchase from Carrio Motors. Their team was professional, knowledgeable, and made the buying process incredibly smooth. My new BMW is everything I wanted and more!"</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/testimonials/testimonial-2.jpg') }}" class="rounded-circle me-3" width="60" height="60" alt="Customer">
                                <div>
                                    <h5 class="mb-0">Sarah Williams</h5>
                                    <small class="text-muted">Mercedes Owner</small>
                                </div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <p class="card-text">"The service department at Carrio Motors is exceptional. They've maintained my Mercedes perfectly for years. Their attention to detail and commitment to quality keeps me coming back. Highly recommended!"</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/testimonials/testimonial-3.jpg') }}" class="rounded-circle me-3" width="60" height="60" alt="Customer">
                                <div>
                                    <h5 class="mb-0">David Chen</h5>
                                    <small class="text-muted">Audi Owner</small>
                                </div>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="card-text">"What sets Carrio Motors apart is their financing team. They found me a great rate and worked with my budget to get me into my dream Audi. The entire staff went above and beyond to ensure I had an amazing experience."</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-primary">Read More Reviews</a>
        </div>
        </div>
    </section>

<!-- FAQ Section -->
<section class="faq-section py-5 bg-white">
    <div class="container">
        <div class="section-title">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our cars and services</p>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <!-- Question 1 -->
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Do you offer financing options?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we offer flexible financing options with competitive interest rates. Our finance team works with multiple lenders to find the best solution for your needs. We offer terms from 24 to 72 months with options for $0 down payment for qualified buyers.
                            </div>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What warranty coverage comes with your vehicles?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                All new vehicles come with a comprehensive manufacturer's warranty. Most of our luxury models include a 4-year/50,000-mile basic warranty and a 6-year/70,000-mile powertrain warranty. We also offer extended warranty options for additional peace of mind.
                            </div>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Can I schedule a test drive online?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can schedule a test drive directly through our website. Simply view the details of the car you're interested in and click the "Schedule Test Drive" button. Alternatively, you can call us at (123) 456-7890 to arrange a convenient time.
                            </div>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Do you accept trade-ins?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we accept trade-ins of all makes and models. Our team will provide a fair market evaluation of your current vehicle, and the value can be applied directly to your new purchase, reducing your out-of-pocket expense.
                            </div>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What maintenance services do you offer?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our service center offers comprehensive maintenance services including oil changes, tire rotations, brake service, multi-point inspections, and major repairs. We use genuine parts and our technicians are factory-trained specialists in luxury and performance vehicles.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal popup --}}
<div id="carModal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carName"></h5>
        <button type="button" class="btn-close" onclick="closeCarPopup()"></button>
      </div>
      <div class="modal-body">
        <img id="carImage" src="" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">
        <p><strong>Price:</strong> $<span id="carPrice"></span></p>
        <p><strong>Rating:</strong> <span id="carRating"></span> ⭐</p>
        <p><strong>Reviews:</strong> <span id="carReviews"></span> reviews</p>
        <h6>Specifications:</h6>
        <ul class="list-group">
          <li class="list-group-item"><strong>Engine:</strong> <span id="carEngine"></span></li>
          <li class="list-group-item"><strong>Fuel Type:</strong> <span id="carFuelType"></span></li>
          <li class="list-group-item"><strong>Transmission:</strong> <span id="carTransmission"></span></li>
          <li class="list-group-item"><strong>Seats:</strong> <span id="carSeats"></span></li>
          <li class="list-group-item"><strong>Color:</strong> <span id="carColor"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
@include('partials.footer')
@endsection

@push('scripts')
<script>
    function openCarPopup(car) {
        document.getElementById('carName').innerText = car.name;
        document.getElementById('carImage').src = car.image_url;
        document.getElementById('carPrice').innerText = car.price ?? 'Updating';
        document.getElementById('carRating').innerText = parseFloat(car.rating).toFixed(1);
        document.getElementById('carReviews').innerText = car.reviews;

        document.getElementById('carEngine').innerText = car.engine ?? 'N/A';
        document.getElementById('carFuelType').innerText = car.fuel_type ?? 'N/A';
        document.getElementById('carTransmission').innerText = car.transmission ?? 'N/A';
        document.getElementById('carSeats').innerText = car.seats ?? 'N/A';
        document.getElementById('carColor').innerText = car.color ?? 'N/A';

        new bootstrap.Modal(document.getElementById('carModal')).show();
    }

    function closeCarPopup() {
        bootstrap.Modal.getInstance(document.getElementById('carModal')).hide();
    }

        let lastClickedCard = null;
    let clickTimer = null;

    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.car-card').forEach(card => {
        card.addEventListener('click', function () {
            const carId = this.dataset.carId;
            const carData = JSON.parse(this.dataset.carJson);

            if (lastClickedCard === this) {
                clearTimeout(clickTimer);
                lastClickedCard = null;
                window.location.href = `/cars/${carId}`;
            } else {
                lastClickedCard = this;

                clickTimer = setTimeout(() => {
                    openCarPopup(carData);
                    lastClickedCard = null;
                }, 600);
            }
        });
        });

        // Video carousel auto-rotation
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.dot');
        let currentSlide = 0;

        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            slides[n].classList.add('active');
            dots[n].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        if (slides.length > 0) {
            setInterval(nextSlide, 6000);

            // Click on dots to navigate
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    showSlide(currentSlide);
                });
            });
        }
    });
</script>
@endpush
