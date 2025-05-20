@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('brands') }}">Brands</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $brand->name }}</li>
        </ol>
    </nav>

    <!-- Brand Header -->
    <div class="row align-items-center mb-5">
        <div class="col-md-3 text-center">
            <img src="{{ $brand->logo_url ?? asset('images/brands/default.png') }}" alt="{{ $brand->name }}" class="img-fluid mb-3" style="max-height: 150px;">
        </div>
        <div class="col-md-9">
            <h1 class="mb-2">{{ $brand->name }}</h1>
            <p class="lead">{{ $brand->cars_count }} models available</p>
            <p>{{ $brand->description ?? 'Explore the full range of ' . $brand->name . ' vehicles available at Carrio Motors. From sedans to SUVs, find the perfect ' . $brand->name . ' for your lifestyle.' }}</p>

            <div class="brand-stats d-flex flex-wrap gap-4 mt-3">
                <div class="stat-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-star-fill text-warning fs-5 me-2"></i>
                        <div>
                            <span class="d-block text-muted small">Average Rating</span>
                            <span class="fw-bold">{{ number_format($brand->averageRating ?? 4.7, 1) }}/5.0</span>
                        </div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check fs-5 me-2 text-primary"></i>
                        <div>
                            <span class="d-block text-muted small">Established</span>
                            <span class="fw-bold">{{ $brand->established_year ?? '1937' }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-globe fs-5 me-2 text-success"></i>
                        <div>
                            <span class="d-block text-muted small">Origin</span>
                            <span class="fw-bold">{{ $brand->country ?? 'Germany' }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-award fs-5 me-2 text-danger"></i>
                        <div>
                            <span class="d-block text-muted small">Awards</span>
                            <span class="fw-bold">{{ $brand->awards_count ?? rand(10, 50) }}+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Controls -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('brand.detail', $brand->slug) }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="sort" class="form-label">Sort By</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="body_type" class="form-label">Body Type</label>
                    <select class="form-select" id="body_type" name="body_type">
                        <option value="">All Types</option>
                        <option value="sedan" {{ request('body_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="suv" {{ request('body_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                        <option value="coupe" {{ request('body_type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                        <option value="truck" {{ request('body_type') == 'truck' ? 'selected' : '' }}>Truck</option>
                        <option value="convertible" {{ request('body_type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="price_range" class="form-label">Price Range</label>
                    <select class="form-select" id="price_range" name="price_range">
                        <option value="">Any Price</option>
                        <option value="0-30000" {{ request('price_range') == '0-30000' ? 'selected' : '' }}>Under $30,000</option>
                        <option value="30000-50000" {{ request('price_range') == '30000-50000' ? 'selected' : '' }}>$30,000 - $50,000</option>
                        <option value="50000-80000" {{ request('price_range') == '50000-80000' ? 'selected' : '' }}>$50,000 - $80,000</option>
                        <option value="80000-120000" {{ request('price_range') == '80000-120000' ? 'selected' : '' }}>$80,000 - $120,000</option>
                        <option value="120000-9999999" {{ request('price_range') == '120000-9999999' ? 'selected' : '' }}>$120,000+</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-select" id="year" name="year">
                        <option value="">Any Year</option>
                        @for($i = date('Y'); $i >= date('Y')-10; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('brand.detail', $brand->slug) }}" class="btn btn-outline-secondary">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- View Controls -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">{{ $brand->name }} Models</h4>
            <p class="text-muted mb-0">Showing {{ $cars->count() }} of {{ $cars->total() }} models</p>
        </div>

        <div class="view-controls">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="grid-view-btn">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="list-view-btn">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Cars Grid View -->
    <div class="row g-4" id="grid-view">
        @forelse($cars as $car)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 car-card hover-shadow border-0">
                <div class="position-relative">
                    <img src="{{ $car->image_url }}" class="card-img-top" alt="{{ $car->name }}" style="height: 200px; object-fit: cover;">
                    @if($car->is_featured)
                        <span class="position-absolute top-0 start-0 bg-warning text-dark px-2 py-1 m-2 rounded-pill fw-bold small">Featured</span>
                    @endif
                    @if($car->discount_percentage > 0)
                        <span class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded-pill fw-bold small">{{ $car->discount_percentage }}% OFF</span>
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $car->name }}</h5>
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            {{ number_format($car->rating ?? 4.5, 1) }}
                        </div>
                    </div>

                    <p class="text-muted">{{ $car->year ?? date('Y') }}</p>

                    <div class="mb-3">
                        @if($car->discount_price)
                            <span class="text-decoration-line-through text-muted me-2">${{ number_format($car->price, 2) }}</span>
                            <span class="fw-bold text-danger">${{ number_format($car->discount_price, 2) }}</span>
                        @else
                            <span class="fw-bold">${{ number_format($car->price ?? 0, 2) }}</span>
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
                            <i class="bi bi-people"></i> {{ $car->seat_number ?? '5' }} seats
                        </span>
                    </div>

                    <div class="mt-auto d-flex justify-content-between">
                        <a href="{{ url('/cars/'.$car->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                        <a href="{{ url('/buy/'.$car->id) }}" class="btn btn-primary btn-sm">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center p-5">
                <i class="bi bi-exclamation-circle display-5 mb-3"></i>
                <h4>No cars found for this brand</h4>
                <p>Try adjusting your filters or check back later for new inventory.</p>
                <a href="{{ route('brand.detail', $brand->slug) }}" class="btn btn-primary mt-2">Clear Filters</a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Cars List View (hidden by default) -->
    <div id="list-view" class="d-none">
        @forelse ($cars as $car)
        <div class="card mb-3 hover-shadow car-card">
            <div class="row g-0">
                <div class="col-md-4 position-relative">
                    <img src="{{ $car->image_url }}" class="img-fluid h-100 w-100 object-fit-cover" alt="{{ $car->name }}">
                    @if($car->is_featured)
                        <span class="position-absolute top-0 start-0 bg-warning text-dark px-2 py-1 m-2 rounded-pill fw-bold small">Featured</span>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                {{ number_format($car->rating ?? 4.5, 1) }}
                            </div>
                        </div>
                        <p class="text-muted">{{ $car->year ?? date('Y') }}</p>

                        <div class="mb-3">
                            @if($car->discount_price)
                                <span class="text-decoration-line-through text-muted me-2">${{ number_format($car->price, 2) }}</span>
                                <span class="h5 fw-bold text-danger">${{ number_format($car->discount_price, 2) }}</span>
                            @else
                                <span class="h5 fw-bold">${{ number_format($car->price ?? 0, 2) }}</span>
                            @endif
                        </div>

                        <div class="car-specs d-flex flex-wrap gap-3 mb-3">
                            <div>
                                <i class="bi bi-fuel-pump me-1"></i> {{ $car->fuel_type ?? 'Petrol' }}
                            </div>
                            <div>
                                <i class="bi bi-gear me-1"></i> {{ $car->transmission ?? 'Automatic' }}
                            </div>
                            <div>
                                <i class="bi bi-speedometer2 me-1"></i> {{ number_format(($car->mileage ?? 0)) }} km
                            </div>
                            <div>
                                <i class="bi bi-people me-1"></i> {{ $car->seat_number ?? '5' }} seats
                            </div>
                        </div>

                        <p class="card-text text-muted mb-3">{{ \Illuminate\Support\Str::limit($car->description ?? 'No description available', 100) }}</p>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ url('/cars/'.$car->id) }}" class="btn btn-outline-primary">View Details</a>
                            <a href="{{ url('/buy/'.$car->id) }}" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info text-center p-5">
            <i class="bi bi-exclamation-circle display-5 mb-3"></i>
            <h4>No cars found for this brand</h4>
            <p>Try adjusting your filters or check back later for new inventory.</p>
            <a href="{{ route('brand.detail', $brand->slug) }}" class="btn btn-primary mt-2">Clear Filters</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $cars->appends(request()->query())->links() }}
    </div>

    <!-- Brand History Section -->
    <div class="brand-history mt-5 pt-4 border-top">
        <h3 class="mb-4">About {{ $brand->name }}</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <p>{{ $brand->long_description ?? 'Founded in ' . ($brand->established_year ?? '1937') . ', ' . $brand->name . ' has established itself as one of the premier automotive brands in the world. With a commitment to innovation, quality, and performance, ' . $brand->name . ' continues to push the boundaries of automotive engineering and design.' }}</p>

                    <p>{{ $brand->additional_info ?? 'Today, ' . $brand->name . ' offers a diverse lineup of vehicles that cater to various lifestyles and needs. From compact cars to luxury sedans, SUVs, and sports cars, each ' . $brand->name . ' model embodies the brand\'s core values of excellence, reliability, and driving pleasure.' }}</p>
                </div>

                <div class="brand-achievements">
                    <h5 class="mb-3">Notable Achievements</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 px-0">
                            <i class="bi bi-trophy text-warning me-2"></i> Winner of numerous prestigious automotive awards
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <i class="bi bi-speedometer2 text-primary me-2"></i> Consistently recognized for outstanding performance and reliability
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <i class="bi bi-shield-check text-success me-2"></i> Industry-leading safety standards and ratings
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <i class="bi bi-gear-wide-connected text-danger me-2"></i> Pioneering advancements in automotive technology
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $brand->name }} Timeline</h5>
                        <ul class="timeline mt-4">
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ $brand->established_year ?? '1937' }}</h6>
                                    <p>Founded in {{ $brand->founded_location ?? 'Germany' }}</p>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ ($brand->established_year ?? 1937) + 15 }}</h6>
                                    <p>Launch of the first iconic model</p>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ ($brand->established_year ?? 1937) + 30 }}</h6>
                                    <p>International expansion and recognition</p>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ ($brand->established_year ?? 1937) + 50 }}</h6>
                                    <p>Introduction of groundbreaking technologies</p>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Today</h6>
                                    <p>Leading innovation in electric and autonomous vehicles</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Models Section -->
    <div class="popular-models mt-5 pt-4 border-top">
        <h3 class="mb-4">Most Popular {{ $brand->name }} Models</h3>
        <div class="row">
            @foreach(range(1, min(3, $cars->count())) as $i)
                @php $popularCar = $cars[$i-1] ?? null; @endphp
                @if($popularCar)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ $popularCar->image_url }}" class="card-img-top" alt="{{ $popularCar->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $popularCar->name }}</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-warning me-2">
                                    <i class="bi bi-star-fill"></i> {{ number_format($popularCar->rating ?? 4.5, 1) }}
                                </div>
                                <span class="text-muted">({{ $popularCar->reviews_count ?? rand(50, 200) }} reviews)</span>
                            </div>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($popularCar->description ?? 'A popular choice among ' . $brand->name . ' enthusiasts, offering excellent performance, comfort, and reliability.', 100) }}</p>
                            <a href="{{ url('/cars/'.$popularCar->id) }}" class="btn btn-outline-primary">Explore Model</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="testimonials mt-5 pt-4 border-top">
        <h3 class="mb-4">What Our Customers Say About {{ $brand->name }}</h3>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"My {{ $brand->name }} has exceeded all my expectations. The performance is exceptional, and the build quality is outstanding. I couldn't be happier with my purchase."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Robert Johnson</h6>
                                <small class="text-muted">{{ $brand->name }} Owner since 2019</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="card-text">"The driving experience of my {{ $brand->name }} is simply incredible. The attention to detail and the technology features make every journey enjoyable. Highly recommend!"</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Sarah Williams</h6>
                                <small class="text-muted">{{ $brand->name }} Owner since 2021</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"As a long-time {{ $brand->name }} enthusiast, I can confidently say that the latest models continue to uphold the brand's legacy of excellence. The perfect combination of luxury and performance."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Michael Chen</h6>
                                <small class="text-muted">{{ $brand->name }} Owner since 2017</small>
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

    /* Timeline styles */
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        list-style: none;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        left: -1.5rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #0d6efd;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #0d6efd;
    }

    .timeline-title {
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // View switching (grid/list)
    document.addEventListener('DOMContentLoaded', function() {
        const gridViewBtn = document.getElementById('grid-view-btn');
        const listViewBtn = document.getElementById('list-view-btn');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');

        gridViewBtn.addEventListener('click', function() {
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
        });

        listViewBtn.addEventListener('click', function() {
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            listView.classList.remove('d-none');
            gridView.classList.add('d-none');
        });
    });
</script>
@endpush
