@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cars</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filter Options</h5>
                    <form action="{{ route('cars') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="d-flex align-items-center">
                                <input type="number" name="min_price" class="form-control form-control-sm me-2" placeholder="Min" value="{{ request('min_price') }}">
                                <span>-</span>
                                <input type="number" name="max_price" class="form-control form-control-sm ms-2" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <select name="brand" class="form-select form-select-sm">
                                <option value="">All Brands</option>
                                <option value="Toyota" {{ request('brand') == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                <option value="Honda" {{ request('brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                <option value="Ford" {{ request('brand') == 'Ford' ? 'selected' : '' }}>Ford</option>
                                <option value="BMW" {{ request('brand') == 'BMW' ? 'selected' : '' }}>BMW</option>
                                <option value="Mercedes" {{ request('brand') == 'Mercedes' ? 'selected' : '' }}>Mercedes</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fuel Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel_type[]" value="Petrol" id="petrol" {{ is_array(request('fuel_type')) && in_array('Petrol', request('fuel_type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="petrol">Petrol</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel_type[]" value="Diesel" id="diesel" {{ is_array(request('fuel_type')) && in_array('Diesel', request('fuel_type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="diesel">Diesel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel_type[]" value="Hybrid" id="hybrid" {{ is_array(request('fuel_type')) && in_array('Hybrid', request('fuel_type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hybrid">Hybrid</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel_type[]" value="Electric" id="electric" {{ is_array(request('fuel_type')) && in_array('Electric', request('fuel_type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="electric">Electric</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Transmission</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transmission" value="Automatic" id="automatic" {{ request('transmission') == 'Automatic' ? 'checked' : '' }}>
                                <label class="form-check-label" for="automatic">Automatic</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transmission" value="Manual" id="manual" {{ request('transmission') == 'Manual' ? 'checked' : '' }}>
                                <label class="form-check-label" for="manual">Manual</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transmission" value="" id="any-transmission" {{ request('transmission') == '' ? 'checked' : '' }}>
                                <label class="form-check-label" for="any-transmission">Any</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        <a href="{{ route('cars') }}" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Car Listings -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">All Cars</h1>
                <div class="d-flex align-items-center">
                    <label class="me-2 text-nowrap">Sort by:</label>
                    <select class="form-select form-select-sm" id="sort-options" style="width: auto;">
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="name-asc">Name: A to Z</option>
                        <option value="name-desc">Name: Z to A</option>
                        <option value="rating-desc">Top Rated</option>
                    </select>
                </div>
            </div>

            <!-- Results count -->
            <div class="mb-4">
                <p class="text-muted mb-4">Showing {{ $cars->count() }} of {{ $cars->count() }} cars</p>
            </div>

            <!-- Car Grid View -->
            <div class="row g-3" id="grid-view">
                @foreach($cars as $car)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <img src="{{ $car->image_url }}" class="card-img-top" alt="{{ $car->name }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning me-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $car->rating)
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $car->rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-muted small">({{ $car->reviews_count ?? rand(5, 50) }} reviews)</span>
                            </div>

                            <div class="mb-3">
                                @if($car->discount_price)
                                <span class="text-decoration-line-through text-muted me-2">${{ number_format($car->price, 2) }}</span>
                                <span class="fw-bold text-danger">${{ number_format($car->discount_price, 2) }}</span>
                                @else
                                <span class="fw-bold">${{ number_format($car->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="car-features d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-fuel-pump"></i> {{ $car->fuel_type ?? 'Petrol' }}
                                </span>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-gear"></i> {{ $car->transmission ?? 'Automatic' }}
                                </span>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-people"></i> {{ $car->seat_number ?? 5 }} seats
                                </span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('car.detail', $car->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                <button class="btn btn-sm btn-outline-danger add-to-wishlist" data-car-id="{{ $car->id }}">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
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

    .add-to-wishlist {
        transition: all 0.2s ease;
    }

    .add-to-wishlist:hover {
        background-color: #dc3545;
        color: white;
    }

    .add-to-wishlist.active {
        background-color: #dc3545;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sort functionality
        const sortDropdown = document.getElementById('sort-options');
        sortDropdown.addEventListener('change', function() {
            // In a real app, this would likely reload the page with a sort parameter
            // For demo purposes, we'll just show an alert
            alert('Sorting by: ' + this.value);
        });

        // Wishlist functionality
        const wishlistButtons = document.querySelectorAll('.add-to-wishlist');
        wishlistButtons.forEach(button => {
            const carId = parseInt(button.getAttribute('data-car-id'));
            const wishlist = JSON.parse(localStorage.getItem('carWishlist')) || [];

            // Set initial state
            if (wishlist.includes(carId)) {
                button.classList.add('active');
                button.innerHTML = '<i class="bi bi-heart-fill"></i>';
            }

            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Get current wishlist
                let currentWishlist = JSON.parse(localStorage.getItem('carWishlist')) || [];

                // Check if car is already in wishlist
                const index = currentWishlist.indexOf(carId);

                if (index === -1) {
                    // Add to wishlist
                    currentWishlist.push(carId);
                    button.classList.add('active');
                    button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                } else {
                    // Remove from wishlist
                    currentWishlist.splice(index, 1);
                    button.classList.remove('active');
                    button.innerHTML = '<i class="bi bi-heart"></i>';
                }

                // Save updated wishlist
                localStorage.setItem('carWishlist', JSON.stringify(currentWishlist));

                // Update wishlist count in header
                if (typeof updateWishlistCount === 'function') {
                    updateWishlistCount();
                }
            });
        });
    });
</script>
@endpush
