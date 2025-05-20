@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
        </ol>
    </nav>

    <h1 class="mb-4">My Wishlist</h1>

    <div id="empty-wishlist" class="d-none">
        <div class="alert alert-info p-5 text-center">
            <i class="bi bi-heart display-4 d-block mb-3"></i>
            <h4>Your wishlist is empty</h4>
            <p class="mb-4">Add cars to your wishlist to save them for later.</p>
            <a href="{{ route('cars') }}" class="btn btn-primary">Browse Cars</a>
        </div>
    </div>

    <div id="wishlist-container">
        <div class="row g-4" id="wishlist-items">
            <!-- Items will be loaded dynamically via JavaScript -->
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

    .wishlist-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .wishlist-remove:hover {
        background: #dc3545;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadWishlist();
    });

    function loadWishlist() {
        const wishlist = JSON.parse(localStorage.getItem('carWishlist')) || [];
        const wishlistContainer = document.getElementById('wishlist-items');
        const emptyWishlist = document.getElementById('empty-wishlist');

        // Check if wishlist is empty
        if (wishlist.length === 0) {
            wishlistContainer.innerHTML = '';
            emptyWishlist.classList.remove('d-none');
            document.getElementById('wishlist-container').classList.add('d-none');
            return;
        }

        // Show wishlist container and hide empty message
        emptyWishlist.classList.add('d-none');
        document.getElementById('wishlist-container').classList.remove('d-none');

        // Clear current items
        wishlistContainer.innerHTML = '';

        // Load each car
        wishlist.forEach(carId => {
            // In a real application, you'd fetch car details from the server
            // For now, we'll simulate with localStorage data or fetch from API
            fetchCarDetails(carId).then(car => {
                if (car) {
                    addCarToWishlistUI(car);
                }
            });
        });
    }

    function fetchCarDetails(carId) {
        // In a real app, this would be an API call
        // For demo, we'll check if the car data is in localStorage (if added from details page)
        const carData = localStorage.getItem(`car_${carId}`);

        if (carData) {
            return Promise.resolve(JSON.parse(carData));
        }

        // If not in localStorage, fetch from API
        return fetch(`/api/cars/${carId}`)
            .then(response => {
                if (!response.ok) {
                    // For demo purposes, return a mock car if API fails
                    return createMockCar(carId);
                }
                return response.json();
            })
            .catch(() => {
                // Fallback to mock data
                return createMockCar(carId);
            });
    }

    function createMockCar(carId) {
        // Create mock car data for demonstration
        return {
            id: carId,
            name: `Car Model ${carId}`,
            image_url: 'https://via.placeholder.com/300x200',
            price: 25000 + (carId * 5000),
            discount_price: Math.random() > 0.5 ? (20000 + (carId * 4000)) : null,
            rating: (Math.random() * 2 + 3).toFixed(1),
            fuel_type: ['Petrol', 'Diesel', 'Hybrid', 'Electric'][Math.floor(Math.random() * 4)],
            transmission: ['Automatic', 'Manual', 'CVT'][Math.floor(Math.random() * 3)],
            seat_number: Math.floor(Math.random() * 3) + 4,
            year: 2023 - Math.floor(Math.random() * 5)
        };
    }

    function addCarToWishlistUI(car) {
        const wishlistItems = document.getElementById('wishlist-items');

        const carElement = document.createElement('div');
        carElement.className = 'col-md-6 col-lg-4';
        carElement.setAttribute('data-car-id', car.id);

        carElement.innerHTML = `
            <div class="card h-100 hover-shadow position-relative">
                <div class="wishlist-remove" onclick="removeFromWishlist(${car.id})">
                    <i class="bi bi-x"></i>
                </div>
                <div class="position-relative">
                    <img src="${car.image_url}" class="card-img-top" alt="${car.name}" style="height: 200px; object-fit: cover;">
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="card-title mb-1">${car.name}</h5>
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i>
                            ${car.rating}
                        </div>
                    </div>
                    <p class="text-muted small mb-2">${car.year}</p>

                    <div class="mb-3">
                        ${car.discount_price ?
                            `<span class="text-decoration-line-through text-muted me-2">$${car.price.toLocaleString()}</span>
                            <span class="fw-bold text-danger">$${car.discount_price.toLocaleString()}</span>` :
                            `<span class="fw-bold">$${car.price.toLocaleString()}</span>`
                        }
                    </div>

                    <div class="car-features d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-fuel-pump"></i> ${car.fuel_type}
                        </span>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-gear"></i> ${car.transmission}
                        </span>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-people"></i> ${car.seat_number} seats
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/cars/${car.id}" class="btn btn-outline-primary btn-sm">View Details</a>
                        <a href="/buy/${car.id}" class="btn btn-primary btn-sm">Buy Now</a>
                    </div>
                </div>
            </div>
        `;

        wishlistItems.appendChild(carElement);
    }

    function removeFromWishlist(carId) {
        // Get current wishlist
        let wishlist = JSON.parse(localStorage.getItem('carWishlist')) || [];

        // Remove car from wishlist
        wishlist = wishlist.filter(id => id !== carId);

        // Save updated wishlist
        localStorage.setItem('carWishlist', JSON.stringify(wishlist));

        // Update UI
        const carElement = document.querySelector(`[data-car-id="${carId}"]`);
        if (carElement) {
            carElement.remove();
        }

        // Update wishlist count
        updateWishlistCount();

        // Check if wishlist is now empty
        if (wishlist.length === 0) {
            document.getElementById('empty-wishlist').classList.remove('d-none');
            document.getElementById('wishlist-container').classList.add('d-none');
        }
    }
</script>
@endpush
