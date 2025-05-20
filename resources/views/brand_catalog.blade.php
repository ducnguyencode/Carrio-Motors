@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars') }}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">Brands</li>
        </ol>
    </nav>

    <!-- Hero Banner -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-dark text-white border-0 rounded-3 overflow-hidden position-relative">
                <img src="{{ asset('images/brands-hero.jpg') }}" class="card-img opacity-50" alt="Luxury Cars" style="height: 300px; object-fit: cover;">
                <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                    <h1 class="card-title display-4 fw-bold">Our Vehicle Brands</h1>
                    <p class="card-text fs-5 mb-4">Discover premium vehicles from the world's leading manufacturers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Brands -->
    <h2 class="mb-4 fw-bold">Featured Brands</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 mb-5">
        @foreach($featuredBrands ?? [] as $brand)
        <div class="col">
            <a href="{{ route('brand.detail', $brand->slug) }}" class="text-decoration-none">
                <div class="card h-100 text-center hover-shadow border-0">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <img src="{{ $brand->logo_url }}" class="img-fluid mx-auto mb-3" alt="{{ $brand->name }}" style="max-height: 80px;">
                        <h5 class="card-title">{{ $brand->name }}</h5>
                        <p class="text-muted small">{{ $brand->cars_count ?? 0 }} models</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

        <!-- Fallback if no featured brands -->
        @if(empty($featuredBrands) || count($featuredBrands) === 0)
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow border-0">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img src="{{ asset('images/brands/bmw.png') }}" class="img-fluid mx-auto mb-3" alt="BMW" style="max-height: 80px;">
                            <h5 class="card-title">BMW</h5>
                            <p class="text-muted small">12 models</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow border-0">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img src="{{ asset('images/brands/mercedes.png') }}" class="img-fluid mx-auto mb-3" alt="Mercedes" style="max-height: 80px;">
                            <h5 class="card-title">Mercedes-Benz</h5>
                            <p class="text-muted small">15 models</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow border-0">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img src="{{ asset('images/brands/audi.png') }}" class="img-fluid mx-auto mb-3" alt="Audi" style="max-height: 80px;">
                            <h5 class="card-title">Audi</h5>
                            <p class="text-muted small">10 models</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow border-0">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img src="{{ asset('images/brands/toyota.png') }}" class="img-fluid mx-auto mb-3" alt="Toyota" style="max-height: 80px;">
                            <h5 class="card-title">Toyota</h5>
                            <p class="text-muted small">18 models</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow border-0">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img src="{{ asset('images/brands/lexus.png') }}" class="img-fluid mx-auto mb-3" alt="Lexus" style="max-height: 80px;">
                            <h5 class="card-title">Lexus</h5>
                            <p class="text-muted small">8 models</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow border-0">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <img src="{{ asset('images/brands/honda.png') }}" class="img-fluid mx-auto mb-3" alt="Honda" style="max-height: 80px;">
                            <h5 class="card-title">Honda</h5>
                            <p class="text-muted small">14 models</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>

    <!-- All Brands -->
    <h2 class="mb-4 fw-bold">All Brands</h2>

    <!-- Alphabet Navigation -->
    <div class="alphabet-nav mb-4 border-top border-bottom py-2">
        <div class="d-flex flex-wrap justify-content-center">
            @foreach(range('A', 'Z') as $letter)
                <a href="#letter-{{ $letter }}" class="px-2 py-1 text-decoration-none {{ isset($brandsByLetter[$letter]) ? 'fw-bold' : 'text-muted' }}">{{ $letter }}</a>
            @endforeach
        </div>
    </div>

    <!-- Brands List -->
    <div class="row">
        @foreach(range('A', 'Z') as $letter)
            @if(isset($brandsByLetter[$letter]) && count($brandsByLetter[$letter]) > 0)
                <div class="col-12 mb-4" id="letter-{{ $letter }}">
                    <h3 class="border-bottom pb-2">{{ $letter }}</h3>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach($brandsByLetter[$letter] as $brand)
                            <div class="col">
                                <a href="{{ route('brand.detail', $brand->slug) }}" class="text-decoration-none">
                                    <div class="card h-100 hover-shadow border-0">
                                        <div class="row g-0 align-items-center p-2">
                                            <div class="col-4">
                                                <img src="{{ $brand->logo_url }}" class="img-fluid" alt="{{ $brand->name }}">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body py-2">
                                                    <h5 class="card-title">{{ $brand->name }}</h5>
                                                    <p class="card-text text-muted small mb-1">{{ $brand->cars_count ?? 0 }} models</p>
                                                    <p class="card-text small text-primary mb-0">View all models <i class="bi bi-arrow-right small"></i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Fallback if no brands data -->
        @if(empty($brandsByLetter))
            @php
            $dummyBrands = [
                'A' => ['Audi', 'Acura', 'Alfa Romeo'],
                'B' => ['BMW', 'Bentley', 'Buick'],
                'C' => ['Cadillac', 'Chevrolet', 'Chrysler'],
                'F' => ['Ferrari', 'Fiat', 'Ford'],
                'H' => ['Honda', 'Hyundai'],
                'J' => ['Jaguar', 'Jeep'],
                'K' => ['Kia'],
                'L' => ['Lamborghini', 'Land Rover', 'Lexus'],
                'M' => ['Maserati', 'Mazda', 'Mercedes-Benz'],
                'N' => ['Nissan'],
                'P' => ['Porsche'],
                'R' => ['Rolls-Royce'],
                'S' => ['Subaru'],
                'T' => ['Tesla', 'Toyota'],
                'V' => ['Volkswagen', 'Volvo']
            ];
            @endphp

            @foreach($dummyBrands as $letter => $brands)
                <div class="col-12 mb-4" id="letter-{{ $letter }}">
                    <h3 class="border-bottom pb-2">{{ $letter }}</h3>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach($brands as $brand)
                            <div class="col">
                                <a href="#" class="text-decoration-none">
                                    <div class="card h-100 hover-shadow border-0">
                                        <div class="row g-0 align-items-center p-2">
                                            <div class="col-4">
                                                <img src="https://via.placeholder.com/80" class="img-fluid" alt="{{ $brand }}">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body py-2">
                                                    <h5 class="card-title">{{ $brand }}</h5>
                                                    <p class="card-text text-muted small mb-1">{{ rand(5, 20) }} models</p>
                                                    <p class="card-text small text-primary mb-0">View all models <i class="bi bi-arrow-right small"></i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Popular Car Types Section -->
    <div class="popular-categories mt-5 pt-4 border-top">
        <h2 class="mb-4 fw-bold">Popular Car Types</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card bg-image-card border-0 rounded-3 overflow-hidden">
                        <img src="{{ asset('images/categories/sedan.jpg') }}" class="card-img" alt="Sedan">
                        <div class="card-img-overlay d-flex align-items-end">
                            <h4 class="text-white m-0 p-3 bg-dark bg-opacity-50 w-100">Sedans</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card bg-image-card border-0 rounded-3 overflow-hidden">
                        <img src="{{ asset('images/categories/suv.jpg') }}" class="card-img" alt="SUV">
                        <div class="card-img-overlay d-flex align-items-end">
                            <h4 class="text-white m-0 p-3 bg-dark bg-opacity-50 w-100">SUVs</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card bg-image-card border-0 rounded-3 overflow-hidden">
                        <img src="{{ asset('images/categories/electric.jpg') }}" class="card-img" alt="Electric">
                        <div class="card-img-overlay d-flex align-items-end">
                            <h4 class="text-white m-0 p-3 bg-dark bg-opacity-50 w-100">Electric</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="#" class="text-decoration-none">
                    <div class="card bg-image-card border-0 rounded-3 overflow-hidden">
                        <img src="{{ asset('images/categories/luxury.jpg') }}" class="card-img" alt="Luxury">
                        <div class="card-img-overlay d-flex align-items-end">
                            <h4 class="text-white m-0 p-3 bg-dark bg-opacity-50 w-100">Luxury</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="testimonials-section mt-5 pt-4 border-top">
        <h2 class="mb-4 fw-bold">What Our Customers Say</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"I purchased a BMW from Carrio Motors last month and couldn't be happier. The sales team was knowledgeable and helped me find exactly what I was looking for."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Michael Johnson</h6>
                                <small class="text-muted">BMW X5 Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"The Mercedes I bought from Carrio Motors exceeded all my expectations. The buying process was smooth and transparent. I'll definitely be back for my next vehicle."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Emily Rodriguez</h6>
                                <small class="text-muted">Mercedes E-Class Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="card-text">"As a first-time luxury car buyer, I appreciated how patient and helpful the Carrio Motors team was. They made sure I found the perfect Audi that suited my lifestyle and budget."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">David Chen</h6>
                                <small class="text-muted">Audi A4 Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .bg-image-card {
        height: 200px;
        transition: all 0.3s ease;
    }

    .bg-image-card img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .bg-image-card:hover img {
        transform: scale(1.05);
    }

    .alphabet-nav a:hover {
        color: var(--bs-primary) !important;
    }
</style>
@endpush
