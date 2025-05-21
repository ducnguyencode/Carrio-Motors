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
                                @foreach($brands as $brand)
                                <option value="{{ $brand->name }}" {{ request('brand') == $brand->name ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fuel Type</label>
                            @foreach($fuelTypes as $fuelType)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel_type[]" value="{{ $fuelType }}" id="{{ strtolower($fuelType) }}" {{ is_array(request('fuel_type')) && in_array($fuelType, request('fuel_type')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ strtolower($fuelType) }}">{{ $fuelType }}</label>
                            </div>
                            @endforeach
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

                        <div class="mb-3">
                            <label class="form-label">Number of Seats</label>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="seats[]" value="2" id="seats-2" {{ is_array(request('seats')) && in_array('2', request('seats')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="seats-2">2 seats</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="seats[]" value="4" id="seats-4" {{ is_array(request('seats')) && in_array('4', request('seats')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="seats-4">4 seats</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="seats[]" value="5" id="seats-5" {{ is_array(request('seats')) && in_array('5', request('seats')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="seats-5">5 seats</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="seats[]" value="7" id="seats-7" {{ is_array(request('seats')) && in_array('7', request('seats')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="seats-7">7+ seats</label>
                                </div>
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
                <form action="{{ route('cars') }}" method="GET" class="d-flex align-items-center">
                    <!-- Add all current filter parameters as hidden inputs to maintain them -->
                    @if(request('min_price'))
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    @endif
                    @if(request('max_price'))
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    @endif
                    @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                    @endif
                    @if(request('transmission'))
                    <input type="hidden" name="transmission" value="{{ request('transmission') }}">
                    @endif
                    @if(is_array(request('fuel_type')))
                        @foreach(request('fuel_type') as $fuel)
                        <input type="hidden" name="fuel_type[]" value="{{ $fuel }}">
                        @endforeach
                    @endif
                    @if(is_array(request('seats')))
                        @foreach(request('seats') as $seat)
                        <input type="hidden" name="seats[]" value="{{ $seat }}">
                        @endforeach
                    @endif

                    <label class="me-2 text-nowrap">Sort by:</label>
                    <select class="form-select form-select-sm" id="sort-options" name="sort" style="width: auto;" onchange="this.form.submit()">
                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name: Z to A</option>
                        <option value="rating-desc" {{ request('sort') == 'rating-desc' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                </form>
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
                        <img src="{{ $car->main_image ? asset('storage/' . $car->main_image) : (($car->carDetails && $car->carDetails->first() && $car->carDetails->first()->main_image) ? asset($car->carDetails->first()->main_image) : asset('images/cars/default.jpg')) }}"
                              class="card-img-top car-image"
                              alt="{{ $car->name }}"
                              data-car-id="{{ $car->id }}"
                              style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <div class="d-flex align-items-center mb-2">
                                <div class="d-flex text-warning me-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $car->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i - 0.5 <= $car->rating)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-muted small">({{ $car->reviews_count }} reviews)</span>
                            </div>

                            <div class="mb-3">
                                @if($car->discount_price)
                                <span class="text-decoration-line-through text-muted me-2">${{ number_format($car->price, 2) }}</span>
                                <span class="fw-bold text-danger">${{ number_format($car->discount_price, 2) }}</span>
                                @else
                                <span class="fw-bold car-price" data-car-id="{{ $car->id }}">${{ number_format(isset($car->carDetails) && $car->carDetails->count() > 0 ? $car->carDetails->first()->price : $car->price, 2) }}</span>
                                @endif
                            </div>

                            <!-- Available Colors -->
                            @if($car->carDetails && $car->carDetails->count() > 0)
                            <div class="available-colors mb-3">
                                <small class="text-muted d-block mb-1">Available colors:</small>
                                <div class="d-flex flex-wrap">
                                    @foreach($car->carDetails as $detail)
                                        @if($detail->carColor)
                                            <span class="color-dot mr-2"
                                                  onclick="updateCarColor('{{ $car->id }}', '{{ $detail->price }}', '{{ $detail->main_image ? asset($detail->main_image) : asset('images/cars/default.jpg') }}', event)"
                                                  data-car-id="{{ $car->id }}"
                                                  data-color-id="{{ $detail->id }}"
                                                  data-price="{{ $detail->price }}"
                                                  data-image="{{ $detail->main_image ? asset($detail->main_image) : asset('images/cars/default.jpg') }}"
                                                  data-color-name="{{ $detail->carColor->name }}"
                                                  style="background-color: {{ $detail->carColor->hex_code ?? '#ccc' }};
                                                       display: inline-block;
                                                       width: 30px;
                                                       height: 30px;
                                                       border-radius: 50%;
                                                       margin: 0 8px 8px 0;
                                                       cursor: pointer;
                                                       border: 3px solid #ddd;
                                                       box-shadow: 0 0 3px rgba(0,0,0,0.3);"></span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="car-features d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-fuel-pump"></i> {{ $car->fuel_type }}
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
                                <a href="{{ route('buy.form', $car->id) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-cart"></i> Buy Now
                                </a>
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

@section('footer')
    @include('partials.footer')
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

    /* Available Colors */
    .color-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px;
        border-radius: 8px;
        cursor: pointer !important;
        transition: all 0.2s ease;
        max-width: 60px;
        text-align: center;
    }

    .color-button:hover {
        transform: scale(1.05);
        background-color: rgba(0, 0, 0, 0.05);
        z-index: 5;
    }

    .color-button.selected {
        background-color: rgba(13, 110, 253, 0.1);
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.3);
    }

    .color-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 2px solid #ddd;
        transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
        display: inline-block;
    }

    .color-button:hover .color-circle {
        border-color: #333;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.3);
    }

    /* Selected color styling */
    .color-button.selected .color-circle {
        border: 3px solid #0d6efd !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.4), 0 0 10px rgba(13, 110, 253, 0.3);
    }

    .color-name {
        font-size: 0.75rem;
        margin-top: 2px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    .color-button.selected .color-name {
        font-weight: bold;
        color: #0d6efd;
    }

    /* Special styling for white color */
    .color-circle[style*="background-color: #fff"],
    .color-circle[style*="background-color: #ffffff"],
    .color-circle[style*="background-color: white"] {
        border: 2px solid #aaa;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.4);
    }

    /* White color indicator */
    .color-circle[style*="background-color: #fff"]::before,
    .color-circle[style*="background-color: #ffffff"]::before,
    .color-circle[style*="background-color: white"]::before {
        content: '';
        position: absolute;
        top: 25%;
        left: 25%;
        right: 25%;
        bottom: 25%;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220,220,220,0.3) 0%, rgba(200,200,200,0.3) 100%);
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Hàm cập nhật màu cho xe
    function updateCarColor(carId, price, imageUrl, event) {
        console.log(`Updating car ${carId} with price ${price} and image ${imageUrl}`);

        // Đảm bảo price là một số
        let numericPrice = price;
        if (typeof price === 'string') {
            // Loại bỏ các ký tự không phải số hoặc dấu chấm
            numericPrice = price.replace(/[^\d.]/g, '');
            console.log('Cleaned price string: ' + numericPrice);
        }

        const parsedPrice = parseFloat(numericPrice);
        console.log('Parsed price as number: ' + parsedPrice);

        if (isNaN(parsedPrice)) {
            console.error('Price is not a valid number: ' + price);
            return;
        }

        // Cập nhật giá
        const priceElement = document.querySelector(`.car-price[data-car-id="${carId}"]`);
        if (priceElement) {
            const formattedPrice = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(parsedPrice);

            priceElement.textContent = '$' + formattedPrice;
            console.log(`Updated price to $${formattedPrice}`);
        }

        // Cập nhật hình ảnh
        const imageElement = document.querySelector(`.car-image[data-car-id="${carId}"]`);
        if (imageElement && imageUrl) {
            imageElement.src = imageUrl;
            console.log(`Updated image to ${imageUrl}`);
        }

        // Thêm hiệu ứng cho màu được chọn
        document.querySelectorAll(`.color-dot[data-car-id="${carId}"]`).forEach(dot => {
            dot.style.border = '3px solid #ddd';
        });

        // Sử dụng event.currentTarget thay vì event.target để đảm bảo lấy đúng phần tử
        if (event && event.currentTarget) {
            event.currentTarget.style.border = '3px solid #0d6efd';
        } else if (event && event.target) {
            event.target.style.border = '3px solid #0d6efd';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Debug: Hiển thị giá cho tất cả các color dot
        console.log('---DEBUG COLOR DOTS---');
        document.querySelectorAll('.color-dot').forEach(dot => {
            const carId = dot.getAttribute('data-car-id');
            const colorName = dot.getAttribute('data-color-name');
            const price = dot.getAttribute('data-price');
            const colorId = dot.getAttribute('data-color-id');

            console.log(`Car: ${carId}, Color: ${colorName}, Price: ${price}, ID: ${colorId}`);
        });
        console.log('---------------------');

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


