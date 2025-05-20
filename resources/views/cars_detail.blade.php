@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars') }}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $car->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Car Images Gallery -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="main-image-container position-relative mb-2">
                    <img id="mainImage" src="{{ $car->image_url }}" class="img-fluid rounded" alt="{{ $car->name }}" style="width: 100%; height: 400px; object-fit: cover;">
                    @if($car->discount_percentage > 0)
                        <div class="position-absolute top-0 end-0 bg-danger text-white py-1 px-3 m-3 rounded-pill">
                            <strong>{{ $car->discount_percentage }}% OFF</strong>
                        </div>
                    @endif
                    @if($car->is_featured)
                        <div class="position-absolute top-0 start-0 bg-warning text-dark py-1 px-3 m-3 rounded-pill">
                            <strong>Featured</strong>
                        </div>
                    @endif
                </div>

                <div class="thumbnail-gallery d-flex overflow-auto p-2">
                    <img src="{{ $car->image_url }}" class="thumbnail-image active me-2 rounded cursor-pointer" onclick="changeMainImage(this.src)" alt="{{ $car->name }}" style="width: 80px; height: 60px; object-fit: cover;">

                    @foreach($car->images ?? [] as $image)
                        <img src="{{ url('storage/' . $image->url) }}" class="thumbnail-image me-2 rounded cursor-pointer" onclick="changeMainImage(this.src)" alt="{{ $car->name }}" style="width: 80px; height: 60px; object-fit: cover;">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Car Details -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="mb-1">{{ $car->name }}</h1>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-secondary me-2">{{ $car->brand->name ?? 'N/A' }}</span>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($car->rating ?? 4.5))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i - 0.5 <= ($car->rating ?? 4.5))
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <span class="text-muted ms-1">({{ $car->reviews_count ?? rand(10, 100) }} reviews)</span>
                            </div>
                        </div>
                    </div>
                    <div class="share-buttons">
                        <button class="btn btn-sm btn-outline-primary" onclick="shareOnSocial('facebook')"><i class="bi bi-facebook"></i></button>
                        <button class="btn btn-sm btn-outline-info" onclick="shareOnSocial('twitter')"><i class="bi bi-twitter"></i></button>
                        <button class="btn btn-sm btn-outline-dark" onclick="shareOnSocial('email')"><i class="bi bi-envelope"></i></button>
                    </div>
                </div>

                <div class="pricing mb-4">
                    @if($car->discount_price)
                        <div class="d-flex align-items-center">
                            <span class="h3 fw-bold text-danger me-3">${{ number_format($car->discount_price, 2) }}</span>
                            <span class="text-decoration-line-through text-muted">${{ number_format($car->price, 2) }}</span>
                            <span class="badge bg-danger ms-2">Save ${{ number_format($car->price - $car->discount_price, 2) }}</span>
                        </div>
                    @else
                        <span class="h3 fw-bold">${{ number_format($car->price ?? 50000, 2) }}</span>
                    @endif

                    <div class="finance-options mt-2">
                        <small class="text-muted">
                            Finance from ${{ number_format(($car->price ?? 50000) / 60, 2) }}/month*
                            <a href="#financing" data-bs-toggle="collapse" role="button" aria-expanded="false">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </small>
                        <div class="collapse mt-2" id="financing">
                            <div class="card card-body bg-light py-2 px-3">
                                <small>*Estimated payment with 20% down, 60-month term at 3.9% APR. Actual terms may vary.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="key-specs d-flex flex-wrap gap-3 mb-4 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-speedometer2 fs-5 me-2 text-primary"></i>
                        <div>
                            <small class="d-block text-muted">Engine</small>
                            <span>{{ $car->engine->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-fuel-pump fs-5 me-2 text-primary"></i>
                        <div>
                            <small class="d-block text-muted">Fuel Type</small>
                            <span>{{ $car->fuel_type ?? 'Petrol' }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-gear fs-5 me-2 text-primary"></i>
                        <div>
                            <small class="d-block text-muted">Transmission</small>
                            <span>{{ $car->transmission }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people fs-5 me-2 text-primary"></i>
                        <div>
                            <small class="d-block text-muted">Seats</small>
                            <span>{{ $car->seat_number }}</span>
                        </div>
                    </div>
                </div>

                <div class="description mb-4">
                    <h5>Description</h5>
                    <p>{{ $car->description }}</p>
                </div>

                <div class="availability mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="dot {{ $car->status == 'available' ? 'bg-success' : 'bg-danger' }} me-2"></span>
                        <span>{{ $car->status == 'available' ? 'In Stock' : 'Out of Stock' }}</span>
                        @if($car->status == 'available')
                            <small class="text-muted ms-2">({{ $car->stock_quantity ?? 1 }} available)</small>
                        @endif
                    </div>
                    <div class="delivery-info d-flex align-items-center">
                        <i class="bi bi-truck me-2 text-primary"></i>
                        <small>Free delivery available | Ready for test drive</small>
                    </div>
                </div>

                <div class="actions d-grid gap-2">
                    <a href="{{ url('/buy/'.$car->id) }}" class="btn btn-primary btn-lg">Buy Now</a>
                    <button class="btn btn-outline-primary" onclick="scheduleTestDrive()">Schedule Test Drive</button>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-dark flex-grow-1" onclick="addToComparison({{ $car->id }})">
                            <i class="bi bi-plus-circle me-2"></i> Add to Comparison
                        </button>
                        <button class="btn btn-outline-danger" id="wishlistBtn" onclick="toggleWishlist({{ $car->id }})">
                            <i class="bi bi-heart-fill" id="wishlistIcon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs for Additional Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" id="carDetailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="true">Specifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab" aria-controls="features" aria-selected="false">Features</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="carDetailTabsContent">
                        <!-- Specifications Tab -->
                        <div class="tab-pane fade show active" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Performance</h5>
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Engine</th>
                                                <td>{{ $car->engine->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Horsepower</th>
                                                <td>{{ $car->horsepower ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Torque</th>
                                                <td>{{ $car->torque ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>0-60 mph</th>
                                                <td>{{ $car->acceleration ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Fuel Consumption</th>
                                                <td>{{ $car->fuel_consumption ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Fuel Type</th>
                                                <td>{{ $car->fuel_type ?? 'Petrol' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Dimensions & Capacity</h5>
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Length</th>
                                                <td>{{ $car->length ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Width</th>
                                                <td>{{ $car->width ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Height</th>
                                                <td>{{ $car->height ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Seating Capacity</th>
                                                <td>{{ $car->seat_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cargo Volume</th>
                                                <td>{{ $car->cargo_volume ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Fuel Tank Capacity</th>
                                                <td>{{ $car->fuel_capacity ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Features Tab -->
                        <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Safety Features</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Anti-lock Braking System
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Multiple Airbags
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Electronic Stability Control
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Tire Pressure Monitoring
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Lane Departure Warning
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Comfort Features</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Climate Control
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Leather Seats
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Heated Front Seats
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Power Adjustable Seats
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Keyless Entry
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Technology Features</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> 10" Infotainment System
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Bluetooth Connectivity
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Apple CarPlay & Android Auto
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Premium Sound System
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Wireless Phone Charging
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h1 class="display-4 fw-bold text-warning">{{ number_format($car->rating ?? 4.5, 1) }}</h1>
                                        <div class="rating-stars mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= ($car->rating ?? 4.5))
                                                    <i class="bi bi-star-fill text-warning fs-5"></i>
                                                @elseif($i - 0.5 <= ($car->rating ?? 4.5))
                                                    <i class="bi bi-star-half text-warning fs-5"></i>
                                                @else
                                                    <i class="bi bi-star text-warning fs-5"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p>Based on {{ $car->reviews_count ?? rand(10, 100) }} reviews</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="rating-bars">
                                        @for($i = 5; $i >= 1; $i--)
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="me-3 text-muted" style="min-width: 40px;">{{ $i }} star</div>
                                                <div class="progress flex-grow-1" style="height: 10px;">
                                                    @php
                                                        // Simulated review distribution
                                                        $percentage = match($i) {
                                                            5 => 65,
                                                            4 => 20,
                                                            3 => 10,
                                                            2 => 3,
                                                            1 => 2,
                                                        };
                                                    @endphp
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="ms-3 text-muted" style="min-width: 40px;">{{ $percentage }}%</span>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <!-- Sample Reviews -->
                            <div class="user-reviews">
                                <h5 class="mb-3">Customer Reviews</h5>

                                <!-- Review Item -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/50" class="rounded-circle me-2" alt="User Avatar">
                                                <div>
                                                    <h6 class="mb-0">John Smith</h6>
                                                    <small class="text-muted">Verified Purchase</small>
                                                </div>
                                            </div>
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                        <h6>Amazing Performance and Comfort</h6>
                                        <p>This car exceeded all my expectations. The handling is top-notch and the interior is luxurious. Highly recommend it for anyone looking for a premium driving experience.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Posted 3 weeks ago</small>
                                            <div>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-hand-thumbs-up"></i> Helpful (12)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Item -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/50" class="rounded-circle me-2" alt="User Avatar">
                                                <div>
                                                    <h6 class="mb-0">Sarah Johnson</h6>
                                                    <small class="text-muted">Verified Purchase</small>
                                                </div>
                                            </div>
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                        <h6>Great Family Car</h6>
                                        <p>Perfect for our family of four. Spacious, comfortable, and good on fuel. The safety features give me peace of mind when driving with my children.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Posted 1 month ago</small>
                                            <div>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-hand-thumbs-up"></i> Helpful (8)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button class="btn btn-outline-primary">Load More Reviews</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Cars Section -->
    <div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-4">Similar Cars You Might Like</h3>
            <div class="row">
                @for($i = 1; $i <= 4; $i++)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 hover-shadow">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Similar Car">
                        <div class="card-body">
                            <h5 class="card-title">Similar Car {{ $i }}</h5>
                            <p class="card-text text-muted">Brand • Model Year</p>
                            <div class="mb-2">
                                <span class="fw-bold">${{ number_format(rand(30000, 80000), 2) }}</span>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating-input">
                            <i class="bi bi-star fs-4 rating-star" data-rating="1"></i>
                            <i class="bi bi-star fs-4 rating-star" data-rating="2"></i>
                            <i class="bi bi-star fs-4 rating-star" data-rating="3"></i>
                            <i class="bi bi-star fs-4 rating-star" data-rating="4"></i>
                            <i class="bi bi-star fs-4 rating-star" data-rating="5"></i>
                            <input type="hidden" name="rating" id="rating-value" value="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="review-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="review-title" placeholder="Summarize your experience">
                    </div>
                    <div class="mb-3">
                        <label for="review-content" class="form-label">Review</label>
                        <textarea class="form-control" id="review-content" rows="4" placeholder="Tell us about your experience with this car"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Submit Review</button>
            </div>
        </div>
    </div>
</div>

<!-- Test Drive Modal -->
<div class="modal fade" id="testDriveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule a Test Drive</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Preferred Date</label>
                        <input type="date" class="form-control" id="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Preferred Time</label>
                        <select class="form-select" id="time" required>
                            <option value="">Select a time</option>
                            <option>9:00 AM</option>
                            <option>10:00 AM</option>
                            <option>11:00 AM</option>
                            <option>1:00 PM</option>
                            <option>2:00 PM</option>
                            <option>3:00 PM</option>
                            <option>4:00 PM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes (Optional)</label>
                        <textarea class="form-control" id="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Schedule Test Drive</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .thumbnail-image {
        cursor: pointer;
        transition: all 0.2s;
        opacity: 0.7;
    }

    .thumbnail-image.active, .thumbnail-image:hover {
        opacity: 1;
        border: 2px solid #0d6efd;
    }

    .hover-shadow {
        transition: all 0.3s;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .rating-star {
        cursor: pointer;
        color: #ccc;
    }

    .rating-star.active {
        color: #ffc107;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
    // Check if car is in wishlist on page load
    document.addEventListener('DOMContentLoaded', function() {
        checkWishlistStatus({{ $car->id }});
    });

    // Image Gallery Functionality
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;

        // Update active thumbnail
        document.querySelectorAll('.thumbnail-image').forEach(img => {
            img.classList.remove('active');
            if (img.src === src) {
                img.classList.add('active');
            }
        });
    }

    // Wishlist functionality
    function toggleWishlist(carId) {
        let wishlist = JSON.parse(localStorage.getItem('carWishlist')) || [];
        const isInWishlist = wishlist.includes(carId);

        if (isInWishlist) {
            // Remove from wishlist
            wishlist = wishlist.filter(id => id !== carId);
            document.getElementById('wishlistBtn').classList.remove('active');
            document.getElementById('wishlistBtn').classList.remove('btn-danger');
            document.getElementById('wishlistBtn').classList.add('btn-outline-danger');
        } else {
            // Add to wishlist
            wishlist.push(carId);
            document.getElementById('wishlistBtn').classList.add('active');
            document.getElementById('wishlistBtn').classList.add('btn-danger');
            document.getElementById('wishlistBtn').classList.remove('btn-outline-danger');

            // Store car data in localStorage for use in wishlist page
            saveCarToLocalStorage(carId);
        }

        // Save updated wishlist
        localStorage.setItem('carWishlist', JSON.stringify(wishlist));

        // Update wishlist count in header
        if (typeof updateWishlistCount === 'function') {
            updateWishlistCount();
        }
    }

    function checkWishlistStatus(carId) {
        const wishlist = JSON.parse(localStorage.getItem('carWishlist')) || [];
        const isInWishlist = wishlist.includes(carId);

        if (isInWishlist) {
            document.getElementById('wishlistBtn').classList.add('active');
            document.getElementById('wishlistBtn').classList.add('btn-danger');
            document.getElementById('wishlistBtn').classList.remove('btn-outline-danger');
        }
    }

    function saveCarToLocalStorage(carId) {
        // Get basic car data from the page
        const car = {
            id: carId,
            name: '{{ $car->name }}',
            image_url: document.getElementById('mainImage').src,
            price: {{ $car->price ?? 0 }},
            discount_price: {{ $car->discount_price ?? 'null' }},
            rating: {{ $car->rating ?? 4.5 }},
            fuel_type: '{{ $car->fuel_type ?? "Petrol" }}',
            transmission: '{{ $car->transmission ?? "Automatic" }}',
            seat_number: {{ $car->seat_number ?? 5 }},
            year: {{ $car->year ?? date('Y') }}
        };

        // Save to localStorage
        localStorage.setItem(`car_${carId}`, JSON.stringify(car));
    }

    // Rating System for Reviews
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            document.getElementById('rating-value').value = rating;

            // Update visual stars
            document.querySelectorAll('.rating-star').forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill');
                    s.classList.add('active');
                } else {
                    s.classList.remove('bi-star-fill');
                    s.classList.add('bi-star');
                    s.classList.remove('active');
                }
            });
        });
    });

    // Share Functionality
    function shareOnSocial(platform) {
        const url = window.location.href;
        const title = document.querySelector('h1').innerText;

        let shareUrl;
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                break;
            case 'email':
                shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(url)}`;
                break;
        }

        window.open(shareUrl, '_blank');
    }

    // Test Drive Modal
    function scheduleTestDrive() {
        const testDriveModal = new bootstrap.Modal(document.getElementById('testDriveModal'));
        testDriveModal.show();
    }

    // Comparison feature
    function addToComparison(carId) {
        // Get existing comparison array from localStorage or create empty array
        let comparisonList = JSON.parse(localStorage.getItem('carComparison')) || [];

        // Check if car is already in the comparison
        if (comparisonList.includes(carId)) {
            alert('This car is already in your comparison list');
            return;
        }

        // Add car to comparison list (max 3 cars)
        if (comparisonList.length >= 3) {
            if (confirm('You can compare up to 3 cars. Would you like to remove the oldest car from your comparison?')) {
                comparisonList.shift(); // Remove the first item
                comparisonList.push(carId); // Add new car
                localStorage.setItem('carComparison', JSON.stringify(comparisonList));
                alert('Car added to comparison');
            }
        } else {
            comparisonList.push(carId);
            localStorage.setItem('carComparison', JSON.stringify(comparisonList));
            alert('Car added to comparison');
        }
    }
</script>
@endpush
