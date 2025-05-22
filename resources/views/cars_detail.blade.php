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

    <style>
        /* Styling for color selection */
        .color-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #ddd;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .color-circle:hover {
            transform: scale(1.15);
            border-color: #333;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.3);
            z-index: 5;
        }

        .variant-selector:checked + .color-circle {
            transform: scale(1.2);
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.4), 0 0 10px rgba(13, 110, 253, 0.3);
            z-index: 6;
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
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220,220,220,0.2) 0%, rgba(200,200,200,0.2) 100%);
            pointer-events: none;
        }

        .color-preview[style*="background-color: #fff"],
        .color-preview[style*="background-color: #ffffff"],
        .color-preview[style*="background-color: white"] {
            border: 1px solid #aaa !important;
            background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(240,240,240,1) 100%) !important;
        }

        /* Active state for color circles */
        .color-option {
            position: relative;
            cursor: pointer;
            padding: 5px;
            border-radius: 8px;
            transition: all 0.2s ease;
            background-color: rgba(0, 0, 0, 0.02);
        }

        .color-option:hover {
            background-color: rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Special styling for black color */
        .color-option:has(input[data-color="Black"]) {
            background-color: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .color-option:has(input[data-color="Black"]):hover {
            background-color: rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .variant-selector:checked + .color-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            pointer-events: none;
        }

        /* White color when selected needs a different indicator */
        .variant-selector:checked + .color-circle[style*="background-color: #fff"]::after,
        .variant-selector:checked + .color-circle[style*="background-color: #ffffff"]::after,
        .variant-selector:checked + .color-circle[style*="background-color: white"]::after {
            background-color: rgba(0, 0, 0, 0.25);
        }

        /* Special styling for black color - make it more noticeable */
        .color-circle[style*="background-color: #000"],
        .color-circle[style*="background-color: black"] {
            border: 2px solid #666;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5), 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Special hover effect for black color */
        .color-circle[style*="background-color: #000"]:hover,
        .color-circle[style*="background-color: black"]:hover {
            transform: scale(1.2);
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.7), 0 0 15px rgba(0, 0, 0, 0.5);
        }

        /* Special styling for black color */
        .color-option-black {
            background-color: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 8px;
            position: relative;
            z-index: 2;
            border-radius: 12px;
        }

        .color-option-black:hover {
            background-color: rgba(0, 0, 0, 0.1);
            transform: translateY(-3px) !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
        }

        /* Enhanced visibility for black color option */
        .color-option-black .color-circle[style*="background-color: #000"],
        .color-option-black .color-circle[style*="background-color: black"] {
            border: 3px solid #999;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.8), 0 0 15px rgba(0, 0, 0, 0.5);
        }

        .color-option-black .text-center {
            font-weight: bold;
            color: #333;
            text-shadow: 0 0 2px rgba(255, 255, 255, 0.5);
        }
    </style>

    <div class="row">
        <!-- Car Images Gallery -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="main-image-container position-relative mb-2">
                    <img id="mainImage"
                        src="{{ ($car->carDetails && $car->carDetails->first() && $car->carDetails->first()->main_image) ? asset($car->carDetails->first()->main_image) : ($car->main_image ? asset('storage/' . $car->main_image) : asset('images/cars/default.jpg')) }}"
                        class="img-fluid rounded"
                        alt="{{ $car->name }}"
                        style="width: 100%; height: 400px; object-fit: cover;">
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

                <div class="thumbnail-gallery d-flex overflow-auto p-2" id="thumbnailGallery">
                    @if($car->carDetails && $car->carDetails->first() && $car->carDetails->first()->main_image)
                        <img src="{{ asset($car->carDetails->first()->main_image) }}"
                            class="thumbnail-image active me-2 rounded cursor-pointer"
                            onclick="changeMainImage(this.src)"
                            alt="{{ $car->name }}"
                            style="width: 80px; height: 60px; object-fit: cover;">

                        @if($car->carDetails->first()->additional_images)
                            @foreach(json_decode($car->carDetails->first()->additional_images) ?? [] as $image)
                                <img src="{{ asset($image) }}"
                                    class="thumbnail-image me-2 rounded cursor-pointer"
                                    onclick="changeMainImage(this.src)"
                                    alt="{{ $car->name }}"
                                    style="width: 80px; height: 60px; object-fit: cover;">
                            @endforeach
                        @endif
                    @else
                        <img src="{{ $car->main_image ? asset('storage/' . $car->main_image) : asset('images/cars/default.jpg') }}"
                            class="thumbnail-image active me-2 rounded cursor-pointer"
                            onclick="changeMainImage(this.src)"
                            alt="{{ $car->name }}"
                            style="width: 80px; height: 60px; object-fit: cover;">

                        @if($car->additional_images)
                            @foreach(json_decode($car->additional_images) ?? [] as $image)
                                <img src="{{ asset('storage/' . $image) }}"
                                    class="thumbnail-image me-2 rounded cursor-pointer"
                                    onclick="changeMainImage(this.src)"
                                    alt="{{ $car->name }}"
                                    style="width: 80px; height: 60px; object-fit: cover;">
                            @endforeach
                        @endif
                    @endif
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
                            <div class="d-flex text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($car->rating ?? 4.5))
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif($i - 0.5 <= ($car->rating ?? 4.5))
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="text-muted ms-1">({{ $car->reviews_count }} reviews)</span>
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
                        <span class="h3 fw-bold" id="main-price">${{ number_format($car->carDetails->first()->price ?? $car->price ?? 50000, 2) }}</span>
                    @endif

                    <div class="finance-options mt-2">
                        <small class="text-muted" id="finance-info">
                            Finance from ${{ number_format(($car->carDetails->first()->price ?? $car->price ?? 50000) / 60, 2) }}/month*
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

                <!-- Car Variants/Colors Section -->
                <div class="car-variants mb-4">
                    <h5>Available Variants</h5>
                    <div class="color-options mb-3">
                        <label class="form-label">Select Color:</label>
                        <!-- Debug information -->
                        @php
                            $variantCount = $car->carDetails->count();
                        @endphp
                        <small class="text-muted d-block mb-2">{{ $variantCount }} color variants found</small>

                        <!-- Debug Information (Chỉ hiển thị khi có query param ?debug=1) -->
                        @if(request()->has('debug'))
                        <div class="alert alert-info mb-3">
                            <h6>Debug Info:</h6>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th>Raw Price Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($car->carDetails as $debug_detail)
                                    <tr>
                                        <td>{{ $debug_detail->id }}</td>
                                        <td>
                                            <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $debug_detail->carColor->hex_code ?? '#ccc' }}; border-radius: 50%; border: 1px solid #aaa;"></span>
                                            {{ $debug_detail->carColor->name ?? 'N/A' }}
                                        </td>
                                        <td>${{ number_format($debug_detail->price, 2) }}</td>
                                        <td><code>{{ var_export($debug_detail->price, true) }}</code></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <div class="d-flex flex-wrap">
                            @foreach($car->carDetails as $detail)
                                @if($detail->carColor)
                                    <div class="color-option me-3 mb-2 {{ $detail->carColor->name === 'Black' ? 'color-option-black' : '' }}"
                                        data-detail-id="{{ $detail->id }}">
                                        <input type="radio" name="car_variant" id="color-{{ $detail->id }}" value="{{ $detail->id }}"
                                            class="visually-hidden variant-selector" data-price="{{ $detail->price ?? $car->price ?? 50000 }}"
                                            data-color="{{ $detail->carColor->name }}" data-quantity="{{ $detail->quantity ?? 0 }}"
                                            data-detail-id="{{ $detail->id }}"
                                            data-main-image="{{ $detail->main_image ? asset($detail->main_image) : '' }}"
                                            data-additional-images="{{ $detail->additional_images }}"
                                            data-engine="{{ $detail->engine ?? $car->engine->name ?? 'N/A' }}"
                                            data-horsepower="{{ $detail->horsepower ?? $car->horsepower ?? 'N/A' }}"
                                            data-torque="{{ $detail->torque ?? $car->torque ?? 'N/A' }}"
                                            data-acceleration="{{ $detail->acceleration ?? $car->acceleration ?? 'N/A' }}"
                                            data-fuel-consumption="{{ $detail->fuel_consumption ?? $car->fuel_consumption ?? 'N/A' }}"
                                            data-fuel-type="{{ $detail->fuel_type ?? $car->fuel_type ?? 'Petrol' }}"
                                            data-transmission="{{ $detail->transmission ?? $car->transmission ?? 'N/A' }}"
                                            data-description="{{ $detail->description ?? '' }}"
                                            data-length="{{ $detail->length ?? $car->length ?? 'N/A' }}"
                                            data-width="{{ $detail->width ?? $car->width ?? 'N/A' }}"
                                            data-height="{{ $detail->height ?? $car->height ?? 'N/A' }}"
                                            data-seat-number="{{ $detail->seat_number ?? $car->seat_number ?? 'N/A' }}"
                                            data-cargo-volume="{{ $detail->cargo_volume ?? $car->cargo_volume ?? 'N/A' }}"
                                            data-fuel-capacity="{{ $detail->fuel_capacity ?? $car->fuel_capacity ?? 'N/A' }}"
                                            data-features="{{ json_encode([
                                                'safety' => $detail->safety_features ?? $car->safety_features ?? [],
                                                'comfort' => $detail->comfort_features ?? $car->comfort_features ?? [],
                                                'technology' => $detail->technology_features ?? $car->technology_features ?? []
                                            ]) }}"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        <label for="color-{{ $detail->id }}" class="color-circle"
                                            style="background-color: {{ $detail->carColor->hex_code ?? '#ccc' }};"
                                            title="{{ $detail->carColor->name }} - ${{ number_format($detail->price, 2) }}"></label>
                                        <div class="text-center mt-1 small">{{ $detail->carColor->name }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="alert alert-info mt-3 p-2 small">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Click on a color circle to see price and availability for that variant
                        </div>
                    </div>

                    <div class="variant-details p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="selected-color fw-bold">
                                    <span class="color-preview d-inline-block align-middle me-2" id="selected-color-preview"
                                        style="width: 16px; height: 16px; border-radius: 50%; background-color: {{ $car->carDetails->first()->carColor->hex_code ?? '#ccc' }}; border: 1px solid #ddd;"></span>
                                    {{ $car->carDetails->first()->carColor->name ?? 'Standard' }}
                                </span>
                                <p class="mb-0 small">{{ $car->carDetails->first()->description ?? '' }}</p>
                            </div>
                            <div class="selected-price h5 mb-0">${{ number_format($car->carDetails->first()->price ?? 0, 2) }}</div>
                        </div>
                        <div class="mt-2 small">
                            <span class="text-success">✓</span> In stock: {{ $car->carDetails->first()->quantity ?? 0 }} available
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
                    @if($car->carDetails && $car->carDetails->count() > 0)
                        <div class="d-flex align-items-center mb-2" id="stock-status">
                            @php
                                $selectedDetail = $car->carDetails->first();
                                $isInStock = $selectedDetail && $selectedDetail->quantity > 0;
                            @endphp
                            <span class="dot {{ $isInStock ? 'bg-success' : 'bg-danger' }} me-2"></span>
                            <span>{{ $isInStock ? 'In Stock' : 'Out of Stock' }}</span>
                            @if($isInStock)
                                <small class="text-muted ms-2">({{ $selectedDetail->quantity }} available)</small>
                            @endif
                        </div>
                    @else
                        <div class="d-flex align-items-center mb-2">
                            <span class="dot {{ $car->status == 'available' ? 'bg-success' : 'bg-danger' }} me-2"></span>
                            <span>{{ $car->status == 'available' ? 'In Stock' : 'Out of Stock' }}</span>
                            @if($car->status == 'available')
                                <small class="text-muted ms-2">({{ $car->stock_quantity ?? 1 }} available)</small>
                            @endif
                        </div>
                    @endif
                    <div class="delivery-info d-flex align-items-center">
                        <i class="bi bi-truck me-2 text-primary"></i>
                        <small>Support delivery available | Ready for test drive</small>
                    </div>
                </div>

                <div class="actions d-grid gap-2">
                    <a href="{{ route('buy.form', $car->id) }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-fill me-2"></i> Buy Now
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                        <i class="bi bi-car-front me-2"></i> Schedule Test Drive
                    </a>
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
                                        <p>Based on {{ $car->reviews_count }} reviews</p>
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

    <!-- INLINE EMERGENCY SCRIPT - Direct color and thumbnails fix -->
    <script>
        // Direct color selection fix - ensures proper UI updates
        (function() {
            // Initialize after page load
            window.addEventListener('load', function() {
                initColorSelection();
                initThumbnailGallery();
            });

            // Initialize immediately and retry after 1 second
            setTimeout(initColorSelection, 0);
            setTimeout(initThumbnailGallery, 0);
            setTimeout(initColorSelection, 1000);
            setTimeout(initThumbnailGallery, 1000);

            // Fix for thumbnails not working
            function initThumbnailGallery() {
                console.log("Initializing thumbnail gallery...");

                // Find all thumbnail images
                const thumbnails = document.querySelectorAll('.thumbnail-image');

                // Remove existing click events and add new ones
                thumbnails.forEach(thumb => {
                    // Clone to remove existing event listeners
                    const newThumb = thumb.cloneNode(true);
                    if (thumb.parentNode) {
                        thumb.parentNode.replaceChild(newThumb, thumb);
                    }

                    // Add new click handler with direct DOM manipulation
                    newThumb.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Get image source
                        const src = this.src;

                        // Update main image
                        const mainImage = document.getElementById('mainImage');
                        if (mainImage) {
                            mainImage.src = src;
                        }

                        // Update active state on thumbnails
                        document.querySelectorAll('.thumbnail-image').forEach(t => {
                            t.classList.remove('active');
                        });
                        this.classList.add('active');

                        console.log("Thumbnail clicked: " + src);
                    });
                });
            }

            // Main fix function for color selection
            function initColorSelection() {
                // Capture all clicks on the page
                document.body.addEventListener('click', function(e) {
                    // Find clicked color circle or color option
                    let targetElement = e.target;
                    let colorCircle = null;

                    // Check if clicked on a color
                    if (targetElement.classList.contains('color-circle')) {
                        colorCircle = targetElement;
                    } else if (targetElement.closest('.color-option')) {
                        colorCircle = targetElement.closest('.color-option').querySelector('.color-circle');
                    }

                    if (!colorCircle) return; // Not a click on color

                    // Prevent default events
                    e.preventDefault();
                    e.stopPropagation();

                    // Find radio button ID
                    const radioId = colorCircle.getAttribute('for');
                    if (!radioId) return;

                    // Find corresponding radio button
                    const radio = document.getElementById(radioId);
                    if (!radio) return;

                    // Get data from radio button
                    const color = radio.getAttribute('data-color');
                    const price = radio.getAttribute('data-price');
                    const quantity = radio.getAttribute('data-quantity');
                    const mainImage = radio.getAttribute('data-main-image');
                    const additionalImages = radio.getAttribute('data-additional-images');

                    // 1. Select radio button
                    radio.checked = true;

                    // 2. Update color display
                    updateColorDisplay(colorCircle, color);

                    // 3. Update price
                    updatePrice(price);

                    // 4. Update stock status
                    updateStock(quantity);

                    // 5. Update image and gallery
                    updateImageAndGallery(mainImage, additionalImages);
                }, true); // capture = true to catch events before other handlers

                // Function to update color display
                function updateColorDisplay(colorCircle, colorName) {
                    const preview = document.getElementById('selected-color-preview');
                    if (!preview) return;

                    // Get color from colorCircle
                    const bgColor = getComputedStyle(colorCircle).backgroundColor;
                    preview.style.backgroundColor = bgColor;

                    // Update text
                    const nameElement = preview.parentElement;
                    if (nameElement) {
                        nameElement.innerHTML = preview.outerHTML + ' ' + colorName;
                    }
                }

                // Function to update price
                function updatePrice(price) {
                    if (!price) return;

                    const numPrice = parseFloat(price.replace(/[^\d.]/g, ''));
                    if (isNaN(numPrice)) return;

                    const formatted = numPrice.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    // Find ALL price elements and update them
                    [
                        '#main-price',
                        '.selected-price',
                        '.pricing .h3',
                        '.variant-details .selected-price',
                        '.h3.fw-bold'
                    ].forEach(selector => {
                        document.querySelectorAll(selector).forEach(el => {
                            if (el) el.textContent = '$' + formatted;
                        });
                    });

                    // Update finance info
                    const financeInfo = document.getElementById('finance-info');
                    if (financeInfo) {
                        const monthlyPayment = (numPrice / 60).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        financeInfo.innerHTML = financeInfo.innerHTML.replace(
                            /\$[\d,]+\.\d{2}\/month\*/,
                            '$' + monthlyPayment + '/month*'
                        );
                    }
                }

                // Function to update stock status
                function updateStock(quantity) {
                    const qty = parseInt(quantity, 10);
                    const inStock = qty > 0;

                    // Update main status
                    const status = document.getElementById('stock-status');
                    if (status) {
                        const dot = status.querySelector('.dot');
                        if (dot) {
                            dot.className = inStock ? 'dot bg-success me-2' : 'dot bg-danger me-2';
                        }

                        const text = status.querySelector('span:not(.dot):not(.text-muted)');
                        if (text) {
                            text.textContent = inStock ? 'In Stock' : 'Out of Stock';
                        }

                        const qtyText = status.querySelector('small.text-muted');
                        if (qtyText) {
                            qtyText.textContent = inStock ? `(${quantity} available)` : '';
                            qtyText.style.display = inStock ? '' : 'none';
                        }
                    }

                    // Update variant details
                    const variantStock = document.querySelector('.variant-details .mt-2.small');
                    if (variantStock) {
                        variantStock.innerHTML = '<span class="text-' + (inStock ? 'success' : 'danger') + '">' +
                            (inStock ? '✓' : '✗') + '</span> ' +
                            (inStock ? 'In stock: ' + quantity + ' available' : 'Out of stock');
                    }
                }

                // Function to update image and gallery
                function updateImageAndGallery(mainImagePath, additionalImagesJson) {
                    if (!mainImagePath) return;

                    // Ensure path is correct
                    if (!mainImagePath.startsWith('http') && !mainImagePath.startsWith('/')) {
                        mainImagePath = '/' + mainImagePath;
                    }

                    // Update main image
                    const mainImg = document.getElementById('mainImage');
                    if (mainImg) {
                        // Force image reload with timestamp
                        const timestamp = new Date().getTime();
                        const newSrc = mainImagePath + (mainImagePath.includes('?') ? '&' : '?') + 'ts=' + timestamp;

                        // Create new image to preload
                        const preloadImg = new Image();
                        preloadImg.onload = function() {
                            mainImg.src = this.src;
                        };
                        preloadImg.onerror = function() {
                            mainImg.src = '/images/cars/default.jpg';
                        };
                        preloadImg.src = newSrc;
                    }

                    // Update gallery thumbnails
                    updateGalleryWithNewImages(mainImagePath, additionalImagesJson);
                }

                // Create fresh thumbnails for selected color
                function updateGalleryWithNewImages(mainImagePath, additionalImagesJson) {
                    // Find the gallery container
                    const gallery = document.getElementById('thumbnailGallery');
                    if (!gallery) return;

                    // Clear current thumbnails
                    gallery.innerHTML = '';

                    // Create thumbnail for main image
                    const mainThumb = createThumbnail(mainImagePath, true);
                    gallery.appendChild(mainThumb);

                    // Process additional images if available
                    if (additionalImagesJson) {
                        try {
                            // Handle different formats of additionalImagesJson
                            let imagesArray;

                            try {
                                // Try parsing as JSON
                                imagesArray = JSON.parse(additionalImagesJson);
                            } catch (e) {
                                // If not valid JSON, try treating as comma-separated string
                                if (typeof additionalImagesJson === 'string') {
                                    imagesArray = additionalImagesJson.split(',').map(img => img.trim());
                                } else {
                                    imagesArray = [];
                                }
                            }

                            // Ensure it's an array
                            if (!Array.isArray(imagesArray)) {
                                imagesArray = [imagesArray];
                            }

                            // Add each additional image
                            imagesArray.forEach(imgPath => {
                                if (!imgPath) return;

                                // Ensure path is a string
                                const imagePath = String(imgPath);

                                // Normalize path
                                let normalizedPath = imagePath;
                                if (!normalizedPath.startsWith('http') && !normalizedPath.startsWith('/')) {
                                    normalizedPath = '/' + normalizedPath;
                                }

                                // Create and add thumbnail
                                const thumb = createThumbnail(normalizedPath, false);
                                gallery.appendChild(thumb);
                            });
                        } catch (e) {
                            console.error('Error processing additional images:', e);
                        }
                    }

                    // Re-initialize thumbnail gallery event handlers
                    initThumbnailGallery();
                }

                // Helper function to create thumbnail elements
                function createThumbnail(imagePath, isActive) {
                    const thumb = document.createElement('img');
                    thumb.src = imagePath;
                    thumb.className = 'thumbnail-image me-2 rounded cursor-pointer' + (isActive ? ' active' : '');
                    thumb.alt = 'Thumbnail';
                    thumb.style = 'width: 80px; height: 60px; object-fit: cover;';

                    // Add error handler
                    thumb.onerror = function() {
                        this.src = '/images/cars/default.jpg';
                        this.onerror = null;
                    };

                    return thumb;
                }

                // Auto-select first color to activate state
                const firstColorCircle = document.querySelector('.color-circle');
                if (firstColorCircle) {
                    firstColorCircle.click();
                }
            }
        })();
    </script>
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

<!-- Purchase Form Modal -->
<div class="modal fade" id="purchaseFormModal" tabindex="-1" aria-labelledby="purchaseFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="purchaseFormModalLabel">Luxury Vehicle Purchase Inquiry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="mb-3">Selected Vehicle</h5>
                                <div class="d-flex align-items-center mb-3">
                                    <div id="modalCarImage" class="me-3 flex-shrink-0">
                                        <!-- Car image will be inserted here via JavaScript -->
                                    </div>
                                    <div>
                                        <h4 id="modalCarName" class="mb-1 fw-bold"></h4>
                                        <div id="modalCarPrice" class="text-primary fs-5 fw-bold"></div>
                                        <div id="selectedCarColor" class="mt-2 d-flex align-items-center">
                                            <span class="d-inline-block me-2" style="width: 20px; height: 20px; border-radius: 50%;" id="colorIndicator"></span>
                                            <span id="colorName"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top border-bottom py-3 my-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Secure Deposit Required:</span>
                                        <span class="fw-bold">10%</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Estimated Delivery:</span>
                                        <span class="fw-bold">3-4 Weeks</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h6 class="mb-3 text-uppercase fw-bold text-muted small">Exclusive Benefits</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span>VIP Dealership Experience</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span>Complimentary First Service</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span>Personalized Delivery</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span>Extended Premium Warranty</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Purchase Information</h5>
                        <form id="purchaseForm" action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="subject" value="Car Purchase">
                            <input type="hidden" name="car" id="carModelInput">

                            <div class="mb-3">
                                <label for="purchaseName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="purchaseName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="purchaseEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="purchaseEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="purchasePhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="purchasePhone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1">
                            </div>
                            <div class="mb-3">
                                <label for="purchasePaymentMethod" class="form-label">Preferred Payment Method</label>
                                <select class="form-select" id="purchasePaymentMethod" name="payment_method" required>
                                    <option value="" selected disabled>Select payment method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Financing">Financing</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="purchaseMessage" class="form-label">Additional Requirements</label>
                                <textarea class="form-control" id="purchaseMessage" name="message" rows="3" placeholder="Optional customization requests or questions..."></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="purchasePrivacy" name="privacy" required>
                                <label class="form-check-label" for="purchasePrivacy">I agree to the privacy policy and terms of service</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('purchaseForm').submit()">
                    <i class="bi bi-send me-2"></i>Submit Inquiry
                </button>
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

    /* Styling for color selection */
    .color-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #ddd;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .color-circle:hover {
        transform: scale(1.15);
        border-color: #333;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.3);
        z-index: 5;
    }

    .variant-selector:checked + .color-circle {
        transform: scale(1.2);
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.4), 0 0 10px rgba(13, 110, 253, 0.3);
        z-index: 6;
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
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220,220,220,0.2) 0%, rgba(200,200,200,0.2) 100%);
        pointer-events: none;
    }

    .color-preview[style*="background-color: #fff"],
    .color-preview[style*="background-color: #ffffff"],
    .color-preview[style*="background-color: white"] {
        border: 1px solid #aaa !important;
        background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(240,240,240,1) 100%) !important;
    }

    /* Active state for color circles */
    .color-option {
        position: relative;
        cursor: pointer;
    }

    .color-option .text-center {
        cursor: pointer;
    }

    .variant-selector:checked + .color-circle::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        pointer-events: none;
    }

    /* White color when selected needs a different indicator */
    .variant-selector:checked + .color-circle[style*="background-color: #fff"]::after,
    .variant-selector:checked + .color-circle[style*="background-color: #ffffff"]::after,
    .variant-selector:checked + .color-circle[style*="background-color: white"]::after {
        background-color: rgba(0, 0, 0, 0.25);
    }

    /* Special styling for black color - make it more noticeable */
    .color-circle[style*="background-color: #000"],
    .color-circle[style*="background-color: black"] {
        border: 2px solid #666;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5), 0 0 10px rgba(0, 0, 0, 0.3);
    }

    /* Special hover effect for black color */
    .color-circle[style*="background-color: #000"]:hover,
    .color-circle[style*="background-color: black"]:hover {
        transform: scale(1.2);
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.7), 0 0 15px rgba(0, 0, 0, 0.5);
    }

    /* Special styling for black color */
    .color-option-black {
        background-color: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .color-option-black:hover {
        background-color: rgba(0, 0, 0, 0.1);
        transform: translateY(-3px) !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
    }

    /* Enhanced visibility for black color option */
    .color-option-black .color-circle[style*="background-color: #000"],
    .color-option-black .color-circle[style*="background-color: black"] {
        border: 3px solid #999;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.8), 0 0 15px rgba(0, 0, 0, 0.5);
    }

    .color-option-black .text-center {
        font-weight: bold;
        color: #333;
        text-shadow: 0 0 2px rgba(255, 255, 255, 0.5);
    }
</style>
@endpush

@push('scripts')
<script>
    // Giải pháp MutationObserver - theo dõi và ghi đè hoàn toàn giao diện người dùng
    document.addEventListener('DOMContentLoaded', function() {
        console.log('▶️ DOM loaded - initializing ULTIMATE FIX with MutationObserver');

        // Lưu giá trị trạng thái hiện tại để so sánh khi có thay đổi
        let currentState = {
            selectedColorId: null,
            price: null,
            color: null
        };

        // Lấy tất cả các phần tử màu và dữ liệu liên quan
        function getAllColorData() {
            const colorData = [];

            // Tìm tất cả các phần tử màu
            document.querySelectorAll('.color-circle').forEach((circle, index) => {
                const radioId = circle.getAttribute('for');
                if (!radioId) return;

                const radio = document.getElementById(radioId);
                if (!radio) return;

                colorData.push({
                    index: index,
                    colorCircle: circle,
                    radio: radio,
                    colorName: radio.getAttribute('data-color'),
                    price: radio.getAttribute('data-price'),
                    quantity: radio.getAttribute('data-quantity'),
                    mainImage: radio.getAttribute('data-main-image'),
                    additionalImages: radio.getAttribute('data-additional-images'),
                    backgroundColor: getComputedStyle(circle).backgroundColor,
                    isChecked: radio.checked
                });
            });

            console.log(`🔍 Found ${colorData.length} color options:`, colorData);
            return colorData;
        }

        // Cập nhật giao diện người dùng cho một màu được chọn
        function updateUIForColor(colorData) {
            if (!colorData) {
                console.error('❌ No color data provided to updateUIForColor');
                return;
            }

            console.log('🔄 Updating UI for color:', colorData);

            // 1. Chọn radio button
            if (!colorData.radio.checked) {
                colorData.radio.checked = true;
            }

            // 2. Cập nhật hiển thị màu
            const colorPreview = document.getElementById('selected-color-preview');
            if (colorPreview) {
                colorPreview.style.backgroundColor = colorData.backgroundColor;

                const colorNameElement = colorPreview.parentElement;
                if (colorNameElement) {
                    colorNameElement.innerHTML = colorPreview.outerHTML + ' ' + colorData.colorName;
                }
            }

            // 3. Cập nhật giá
            const priceValue = parseFloat(colorData.price.replace(/[^\d.]/g, ''));
            if (!isNaN(priceValue)) {
                const formattedPrice = priceValue.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                // Cập nhật TẤT CẢ các phần tử hiển thị giá
                document.querySelectorAll('#main-price, .selected-price, .pricing .h3, h3.fw-bold, .variant-details .selected-price, .h3.fw-bold').forEach(el => {
                    if (el) {
                        el.textContent = '$' + formattedPrice;
                    }
                });

                // Cập nhật thông tin tài chính
                const financeInfo = document.getElementById('finance-info');
                if (financeInfo) {
                    const monthlyPayment = (priceValue / 60).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    financeInfo.innerHTML = financeInfo.innerHTML.replace(
                        /\$[\d,]+\.\d{2}\/month\*/,
                        '$' + monthlyPayment + '/month*'
                    );
                }
            }

            // 4. Cập nhật trạng thái tồn kho
            const quantity = parseInt(colorData.quantity, 10);
            const isInStock = quantity > 0;

            // Phần tử trạng thái tồn kho chính
            const stockStatus = document.getElementById('stock-status');
            if (stockStatus) {
                const dot = stockStatus.querySelector('.dot');
                if (dot) {
                    dot.className = isInStock ? 'dot bg-success me-2' : 'dot bg-danger me-2';
                }

                const statusText = stockStatus.querySelector('span:not(.dot):not(.text-muted)');
                if (statusText) {
                    statusText.textContent = isInStock ? 'In Stock' : 'Out of Stock';
                }

                const quantityEl = stockStatus.querySelector('small.text-muted');
                if (quantityEl) {
                    quantityEl.textContent = isInStock ? `(${quantity} available)` : '';
                    quantityEl.style.display = isInStock ? '' : 'none';
                }
            }

            // Phần tử hiển thị trạng thái tồn kho trong chi tiết biến thể
            const variantStock = document.querySelector('.variant-details .mt-2.small');
            if (variantStock) {
                variantStock.innerHTML = '<span class="text-' + (isInStock ? 'success' : 'danger') + '">' +
                (isInStock ? '✓' : '✗') + '</span> ' +
                (isInStock ? 'In stock: ' + quantity + ' available' : 'Out of stock');
        }

            // 5. Cập nhật hình ảnh
            if (colorData.mainImage) {
                const mainImageEl = document.getElementById('mainImage');
                if (mainImageEl) {
                    let imagePath = colorData.mainImage;
                    if (!imagePath.startsWith('http') && !imagePath.startsWith('/')) {
                        imagePath = '/' + imagePath;
                    }

                    mainImageEl.src = imagePath;

                    // Cập nhật gallery hình ảnh
                    updateGallery(imagePath, colorData.additionalImages);
                }
            }

            // 6. Cập nhật thông số kỹ thuật
            updateSpecs(colorData.radio);

            // Cập nhật trạng thái hiện tại
            currentState = {
                selectedColorId: colorData.radio.id,
                price: colorData.price,
                color: colorData.colorName
            };

            console.log('✅ UI updated successfully for', colorData.colorName);
        }

        // Cập nhật gallery hình ảnh
        function updateGallery(mainImage, additionalImagesJson) {
            if (!mainImage) return;

            // Chuẩn bị hình ảnh chính
            if (!mainImage.startsWith('http') && !mainImage.startsWith('/')) {
                mainImage = '/' + mainImage;
            }

            // Phân tích cú pháp hình ảnh bổ sung nếu có
        let additionalImages = [];
        if (additionalImagesJson) {
            try {
                additionalImages = JSON.parse(additionalImagesJson);
            } catch (e) {
                console.error('Failed to parse additional images:', e);
            }
        }

            // Đảm bảo đường dẫn đúng cho hình ảnh bổ sung
            additionalImages = additionalImages.map(img => {
                if (!img.startsWith('http') && !img.startsWith('/')) {
                    return '/' + img;
                }
                return img;
            });

            // Cập nhật gallery
        const galleryElement = document.getElementById('thumbnailGallery');
            if (!galleryElement) return;

            // Xóa các thumbnail hiện tại
            galleryElement.innerHTML = '';

            // Thêm hình ảnh chính làm thumbnail đầu tiên
                const mainThumb = document.createElement('img');
                mainThumb.src = mainImage;
                mainThumb.className = 'thumbnail-image active me-2 rounded cursor-pointer';
                mainThumb.alt = 'Thumbnail';
                mainThumb.style = 'width: 80px; height: 60px; object-fit: cover;';
                mainThumb.onclick = function() { changeMainImage(this.src); };

            // Thêm xử lý lỗi cho thumbnail
            mainThumb.onerror = function() {
                this.src = '/images/cars/default.jpg';
                this.onerror = null;
            };

                galleryElement.appendChild(mainThumb);

            // Thêm các hình ảnh bổ sung làm thumbnail
            if (additionalImages && additionalImages.length > 0) {
                additionalImages.forEach(image => {
                    const thumb = document.createElement('img');
                    thumb.src = image;
                    thumb.className = 'thumbnail-image me-2 rounded cursor-pointer';
                    thumb.alt = 'Thumbnail';
                    thumb.style = 'width: 80px; height: 60px; object-fit: cover;';
                    thumb.onclick = function() { changeMainImage(this.src); };

                    thumb.onerror = function() {
                        this.src = '/images/cars/default.jpg';
                        this.onerror = null;
                    };

                    galleryElement.appendChild(thumb);
                });
            }
        }

        // Cập nhật thông số kỹ thuật
        function updateSpecs(radioInput) {
            if (!radioInput) return;

            try {
                // Cố gắng sử dụng hàm hiện có nếu được định nghĩa
                if (typeof updateSpecifications === 'function') {
                    updateSpecifications(radioInput);
                } else {
                    // Tự triển khai cập nhật thông số kỹ thuật
                    const specMappings = [
                        { attr: 'engine', selector: '#specs tbody tr:nth-child(1) td' },
                        { attr: 'horsepower', selector: '#specs tbody tr:nth-child(2) td' },
                        { attr: 'torque', selector: '#specs tbody tr:nth-child(3) td' },
                        { attr: 'acceleration', selector: '#specs tbody tr:nth-child(4) td' },
                        { attr: 'fuel-consumption', selector: '#specs tbody tr:nth-child(5) td' },
                        { attr: 'fuel-type', selector: '#specs tbody tr:nth-child(6) td' },
                        { attr: 'transmission', selector: 'tbody tr:nth-child(7) td, .key-specs .d-flex:nth-child(3) span' },
                        { attr: 'seat-number', selector: '.key-specs .d-flex:nth-child(4) span' }
                    ];

                    // Cập nhật từng thông số nếu có dữ liệu
                    specMappings.forEach(spec => {
                        const value = radioInput.getAttribute('data-' + spec.attr);
            if (value) {
                            document.querySelectorAll(spec.selector).forEach(el => {
                                el.textContent = value;
                            });
                        }
                    });
                }
            } catch (e) {
                console.error('Error updating specifications:', e);
            }
        }

        // Thiết lập MutationObserver để theo dõi thay đổi DOM
        const colorObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                // Kiểm tra xem có radio button nào được chọn
                if (mutation.type === 'attributes' &&
                    mutation.attributeName === 'checked' &&
                    mutation.target.name === 'car_variant') {

                    console.log('🔄 Detected change in car variant selection:', mutation.target);

                    // Tìm dữ liệu màu cho radio button được chọn
                    const allColors = getAllColorData();
                    const selectedColor = allColors.find(c => c.radio === mutation.target);

                    if (selectedColor) {
                        updateUIForColor(selectedColor);
                    }
                }
            });
        });

        // Khởi tạo xử lý trực tiếp cho click
        function setupDirectClickHandlers() {
            console.log('🔧 Setting up direct click handlers for color circles');

            document.querySelectorAll('.color-circle, .color-option').forEach((element) => {
                // Tạo bản sao phần tử để loại bỏ tất cả các trình xử lý sự kiện hiện có
                const newElement = element.cloneNode(true);
                if (element.parentNode) {
                    element.parentNode.replaceChild(newElement, element);
                }

                // Thêm trình xử lý sự kiện mới
                newElement.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    console.log('🖱️ Direct click detected on:', this);

                    // Xác định phần tử màu
                    let colorCircle = this;
                    if (this.classList.contains('color-option')) {
                        colorCircle = this.querySelector('.color-circle');
                    }

                    if (!colorCircle) {
                        console.error('❌ Could not find color circle element');
                        return;
                    }

                    // Tìm và cập nhật màu được chọn
                    const allColors = getAllColorData();
                    const clickedColor = allColors.find(c => c.colorCircle === colorCircle);

                    if (clickedColor) {
                        updateUIForColor(clickedColor);
                    } else {
                        console.error('❌ Could not find color data for clicked circle');
                    }
                }, true);
            });
        }

        // Start MutationObserver
        const config = {
            attributes: true,
            childList: true,
            subtree: true,
            attributeFilter: ['checked']
        };

        // Bắt đầu quan sát thay đổi trên toàn bộ trang
        colorObserver.observe(document.body, config);

        // Thiết lập trình xử lý click trực tiếp
        setTimeout(setupDirectClickHandlers, 1000);

        // Thiết lập trình xử lý toàn cục để bắt tất cả các click trên trang
        document.addEventListener('click', function(e) {
            // Check if click was on or near a color option
            let element = e.target;

            // Walk up the DOM tree
            while (element && element !== document) {
                if (element.classList.contains('color-circle') ||
                    element.classList.contains('color-option') ||
                    element.parentElement?.classList.contains('color-option')) {

                    console.log('🎯 Global click intercepted on color element:', element);

                    // Find the actual circle
                    let colorCircle = element;
                    if (element.classList.contains('color-option')) {
                        colorCircle = element.querySelector('.color-circle');
                    } else if (element.parentElement?.classList.contains('color-option')) {
                        colorCircle = element.parentElement.querySelector('.color-circle');
                    }

                    if (!colorCircle) {
                        console.error('❌ Could not find color circle from clicked element');
                        return;
                    }

                    // Find and update the selected color
                    const allColors = getAllColorData();
                    const clickedColor = allColors.find(c => c.colorCircle === colorCircle ||
                                                        c.colorCircle.getAttribute('for') === colorCircle.getAttribute('for'));

                    if (clickedColor) {
                        updateUIForColor(clickedColor);
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                }

                element = element.parentElement;
            }
        }, true);

        // Thêm chức năng chọn màu từ console
        window.forceSelectColor = function(index) {
            const colorData = getAllColorData();
            if (colorData.length > index) {
                console.log(`⚡ Manually forcing color selection for index ${index}:`, colorData[index]);
                updateUIForColor(colorData[index]);
                return true;
            } else {
                console.error(`❌ No color found at index ${index}. Available colors:`, colorData.length);
                return false;
            }
        };

        // Chọn màu mặc định ban đầu
        setTimeout(function() {
            const colorData = getAllColorData();
            if (colorData.length > 0) {
                // Tìm màu đã được chọn hoặc sử dụng màu đầu tiên
                const selectedColor = colorData.find(c => c.isChecked) || colorData[0];
                console.log('🔄 Selecting initial color:', selectedColor);
                updateUIForColor(selectedColor);
            }
        }, 500);

        console.log('✅ ULTIMATE FIX initialized successfully');
        console.log('💡 TIP: You can manually force color selection by running in console: forceSelectColor(0) or forceSelectColor(1)');
    });

    // Function to change main image when clicking on thumbnails
    function changeMainImage(src) {
        const mainImage = document.getElementById('mainImage');
        if (mainImage) {
            mainImage.src = src;
        }

        // Update active state on thumbnails
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        thumbnails.forEach(thumb => {
            thumb.classList.remove('active');
            if (thumb.src === src) {
                thumb.classList.add('active');
            }
        });
    }

    // Social sharing functions
    function shareOnSocial(platform) {
        const url = window.location.href;
        const title = document.querySelector('h1').textContent;

        let shareUrl = '';

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

        if (shareUrl) {
            window.open(shareUrl, '_blank');
        }
    }
</script>
@endpush
