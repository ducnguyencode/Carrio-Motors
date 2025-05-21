@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars') }}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">Compare Cars</li>
        </ol>
    </nav>

    <h1 class="mb-4">Compare Cars</h1>

    <div id="empty-comparison" class="d-none">
        <div class="alert alert-info p-5 text-center">
            <i class="bi bi-exclamation-circle display-4 d-block mb-3"></i>
            <h4>No Cars Selected for Comparison</h4>
            <p class="mb-4">Add up to 3 cars to compare their specifications and features side by side.</p>
            <a href="{{ route('cars') }}" class="btn btn-primary">Browse Cars</a>
        </div>
    </div>

    <div id="comparison-container">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row" id="comparison-header">
                    <!-- Car Selection Column -->
                    <div class="col-3">
                        <h5 class="mb-0">Specifications</h5>
                    </div>

                    <!-- Car slots will be added dynamically -->
                    <div class="col-3 text-center car-slot" id="car-slot-1">
                        <div class="car-selection">
                            <button id="select-car-1" class="btn btn-outline-primary select-car-btn">
                                <i class="bi bi-plus-circle me-2"></i> Add Car
                            </button>
                        </div>
                        <div class="selected-car d-none">
                            <div class="position-relative">
                                <img id="car-image-1" src="" class="img-fluid rounded mb-2" alt="">
                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle remove-car" data-slot="1">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <h5 id="car-name-1" class="mb-0"></h5>
                            <p id="car-price-1" class="text-success fw-bold"></p>
                        </div>
                    </div>

                    <div class="col-3 text-center car-slot" id="car-slot-2">
                        <div class="car-selection">
                            <button id="select-car-2" class="btn btn-outline-primary select-car-btn">
                                <i class="bi bi-plus-circle me-2"></i> Add Car
                            </button>
                        </div>
                        <div class="selected-car d-none">
                            <div class="position-relative">
                                <img id="car-image-2" src="" class="img-fluid rounded mb-2" alt="">
                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle remove-car" data-slot="2">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <h5 id="car-name-2" class="mb-0"></h5>
                            <p id="car-price-2" class="text-success fw-bold"></p>
                        </div>
                    </div>

                    <div class="col-3 text-center car-slot" id="car-slot-3">
                        <div class="car-selection">
                            <button id="select-car-3" class="btn btn-outline-primary select-car-btn">
                                <i class="bi bi-plus-circle me-2"></i> Add Car
                            </button>
                        </div>
                        <div class="selected-car d-none">
                            <div class="position-relative">
                                <img id="car-image-3" src="" class="img-fluid rounded mb-2" alt="">
                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle remove-car" data-slot="3">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <h5 id="car-name-3" class="mb-0"></h5>
                            <p id="car-price-3" class="text-success fw-bold"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Performance Section -->
                <div class="comparison-section">
                    <div class="comparison-section-header bg-light p-3">
                        <h5 class="mb-0">Performance</h5>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Engine</div>
                        <div class="col-3 px-3 text-center car-data" id="car-engine-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-engine-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-engine-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Horsepower</div>
                        <div class="col-3 px-3 text-center car-data" id="car-horsepower-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-horsepower-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-horsepower-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Torque</div>
                        <div class="col-3 px-3 text-center car-data" id="car-torque-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-torque-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-torque-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">0-60 mph</div>
                        <div class="col-3 px-3 text-center car-data" id="car-acceleration-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-acceleration-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-acceleration-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Transmission</div>
                        <div class="col-3 px-3 text-center car-data" id="car-transmission-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-transmission-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-transmission-3">-</div>
                    </div>
                </div>

                <!-- Fuel & Efficiency Section -->
                <div class="comparison-section">
                    <div class="comparison-section-header bg-light p-3">
                        <h5 class="mb-0">Fuel & Efficiency</h5>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Fuel Type</div>
                        <div class="col-3 px-3 text-center car-data" id="car-fuel-type-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-fuel-type-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-fuel-type-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">City MPG</div>
                        <div class="col-3 px-3 text-center car-data" id="car-city-mpg-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-city-mpg-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-city-mpg-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Highway MPG</div>
                        <div class="col-3 px-3 text-center car-data" id="car-highway-mpg-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-highway-mpg-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-highway-mpg-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Fuel Tank Capacity</div>
                        <div class="col-3 px-3 text-center car-data" id="car-fuel-capacity-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-fuel-capacity-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-fuel-capacity-3">-</div>
                    </div>
                </div>

                <!-- Dimensions Section -->
                <div class="comparison-section">
                    <div class="comparison-section-header bg-light p-3">
                        <h5 class="mb-0">Dimensions & Capacity</h5>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Length</div>
                        <div class="col-3 px-3 text-center car-data" id="car-length-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-length-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-length-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Width</div>
                        <div class="col-3 px-3 text-center car-data" id="car-width-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-width-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-width-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Height</div>
                        <div class="col-3 px-3 text-center car-data" id="car-height-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-height-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-height-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Wheelbase</div>
                        <div class="col-3 px-3 text-center car-data" id="car-wheelbase-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-wheelbase-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-wheelbase-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Seating Capacity</div>
                        <div class="col-3 px-3 text-center car-data" id="car-seating-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-seating-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-seating-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Cargo Volume</div>
                        <div class="col-3 px-3 text-center car-data" id="car-cargo-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-cargo-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-cargo-3">-</div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="comparison-section">
                    <div class="comparison-section-header bg-light p-3">
                        <h5 class="mb-0">Features</h5>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Infotainment</div>
                        <div class="col-3 px-3 text-center car-data" id="car-infotainment-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-infotainment-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-infotainment-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Climate Control</div>
                        <div class="col-3 px-3 text-center car-data" id="car-climate-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-climate-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-climate-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Safety Features</div>
                        <div class="col-3 px-3 text-center car-data" id="car-safety-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-safety-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-safety-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Advanced Driver Assistance</div>
                        <div class="col-3 px-3 text-center car-data" id="car-adas-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-adas-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-adas-3">-</div>
                    </div>
                </div>

                <!-- Pricing & Warranty Section -->
                <div class="comparison-section">
                    <div class="comparison-section-header bg-light p-3">
                        <h5 class="mb-0">Pricing & Warranty</h5>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Starting MSRP</div>
                        <div class="col-3 px-3 text-center car-data" id="car-msrp-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-msrp-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-msrp-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Destination Fee</div>
                        <div class="col-3 px-3 text-center car-data" id="car-destination-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-destination-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-destination-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Basic Warranty</div>
                        <div class="col-3 px-3 text-center car-data" id="car-warranty-basic-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-warranty-basic-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-warranty-basic-3">-</div>
                    </div>

                    <div class="row g-0 border-bottom py-3">
                        <div class="col-3 px-3 fw-bold">Powertrain Warranty</div>
                        <div class="col-3 px-3 text-center car-data" id="car-warranty-powertrain-1">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-warranty-powertrain-2">-</div>
                        <div class="col-3 px-3 text-center car-data" id="car-warranty-powertrain-3">-</div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white py-3">
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3 text-center buy-btn-container-1 d-none">
                        <a href="#" id="buy-car-1" class="btn btn-primary w-100">Buy Now</a>
                    </div>
                    <div class="col-3 text-center buy-btn-container-2 d-none">
                        <a href="#" id="buy-car-2" class="btn btn-primary w-100">Buy Now</a>
                    </div>
                    <div class="col-3 text-center buy-btn-container-3 d-none">
                        <a href="#" id="buy-car-3" class="btn btn-primary w-100">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Car Selection Modal -->
<div class="modal fade" id="carSelectionModal" tabindex="-1" aria-labelledby="carSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carSelectionModalLabel">Select a Car to Compare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="car-search" placeholder="Search for a car...">
                </div>

                <div class="row" id="car-selection-grid">
                    <!-- Sample car data, will be populated from API in real implementation -->
                    @foreach(range(1, 9) as $i)
                    <div class="col-md-4 mb-3 car-selection-item">
                        <div class="card h-100 hover-shadow cursor-pointer"
                             onclick="selectCar({{ $i }}, 'Car Model {{ $i }}', 'https://via.placeholder.com/300x200', {{ 25000 + ($i * 5000) }})">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Car {{ $i }}">
                            <div class="card-body">
                                <h5 class="card-title">Car Model {{ $i }}</h5>
                                <p class="text-muted">Brand Name</p>
                                <p class="fw-bold text-success">${{ number_format(25000 + ($i * 5000), 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .comparison-section {
        margin-bottom: 1rem;
    }

    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Highlight different values */
    .highlight-best {
        color: #198754;
        font-weight: bold;
    }

    .highlight-worst {
        color: #dc3545;
    }

    .remove-car {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
    // Global variable to track current selected slot for the modal
    let currentSlot = null;
    let selectedCars = {};

    // Initialize page state from localStorage
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, checking Bootstrap availability:', typeof bootstrap);

        // Get cars from localStorage
        const comparisonList = JSON.parse(localStorage.getItem('carComparison')) || [];

        if (comparisonList.length === 0) {
            document.getElementById('empty-comparison').classList.remove('d-none');
            document.getElementById('comparison-container').classList.add('d-none');
        } else {
            document.getElementById('empty-comparison').classList.add('d-none');
            document.getElementById('comparison-container').classList.remove('d-none');

            // Load saved cars (would normally fetch from API)
            // This is dummy data for demo purposes
            comparisonList.forEach((carId, index) => {
                const slotNumber = index + 1;
                // In a real app, you would fetch car details from your API
                mockLoadCarData(carId, slotNumber);
            });
        }

        // Setup event listeners
        setupEventListeners();

        // Initialize Bootstrap modals
        if (typeof bootstrap !== 'undefined') {
            console.log('Bootstrap found, registering click handlers');
            // Modal is already initialized
            document.querySelectorAll('.select-car-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Add Car button clicked');

                    // Get the slot number from the button ID
                    currentSlot = parseInt(this.id.replace('select-car-', ''));
                    console.log('Current slot:', currentSlot);

                    // Show the car selection modal
                    const carSelectionModal = new bootstrap.Modal(document.getElementById('carSelectionModal'));
                    console.log('Modal initialized:', carSelectionModal);
                    carSelectionModal.show();
                });
            });
        } else {
            console.log('Bootstrap not found, attempting to load it');
            // Load Bootstrap JavaScript if it's not already loaded
            const bootstrapScript = document.createElement('script');
            bootstrapScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js';
            bootstrapScript.integrity = 'sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4';
            bootstrapScript.crossOrigin = 'anonymous';
            bootstrapScript.onload = function() {
                console.log('Bootstrap loaded dynamically');
                // Bootstrap loaded, now initialize the modal and add event listeners
                document.querySelectorAll('.select-car-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('Add Car button clicked (after dynamic load)');

                        // Get the slot number from the button ID
                        currentSlot = parseInt(this.id.replace('select-car-', ''));
                        console.log('Current slot:', currentSlot);

                        // Show the car selection modal
                        const carSelectionModal = new bootstrap.Modal(document.getElementById('carSelectionModal'));
                        console.log('Modal initialized:', carSelectionModal);
                        carSelectionModal.show();
                    });
                });
            };
            document.head.appendChild(bootstrapScript);
        }
    });

    // Mock function to load car data - in a real app this would be an API call
    function mockLoadCarData(carId, slotNumber) {
        // Simulated car data
        const car = {
            id: carId,
            name: `Car Model ${carId}`,
            price: 25000 + (carId * 5000),
            image_url: 'https://via.placeholder.com/300x200',
            engine: ['2.0L Inline-4', '3.0L V6', '5.0L V8'][Math.floor(Math.random() * 3)],
            horsepower: Math.floor(Math.random() * 300) + 150 + ' hp',
            torque: Math.floor(Math.random() * 300) + 150 + ' lb-ft',
            acceleration: (Math.random() * 3 + 4).toFixed(1) + ' sec',
            transmission: ['8-speed Automatic', '6-speed Manual', '7-speed DCT'][Math.floor(Math.random() * 3)],
            fuel_type: ['Gasoline', 'Diesel', 'Hybrid', 'Electric'][Math.floor(Math.random() * 4)],
            city_mpg: Math.floor(Math.random() * 10) + 20,
            highway_mpg: Math.floor(Math.random() * 10) + 25,
            fuel_capacity: Math.floor(Math.random() * 5) + 15 + ' gal',
            length: Math.floor(Math.random() * 20) + 180 + ' in',
            width: Math.floor(Math.random() * 10) + 70 + ' in',
            height: Math.floor(Math.random() * 5) + 55 + ' in',
            wheelbase: Math.floor(Math.random() * 10) + 105 + ' in',
            seating: Math.floor(Math.random() * 3) + 4,
            cargo: Math.floor(Math.random() * 10) + 10 + ' cu ft',
            infotainment: Math.floor(Math.random() * 5) + 8 + '" Touchscreen',
            climate: ['Dual-zone', 'Single-zone', 'Tri-zone'][Math.floor(Math.random() * 3)],
            safety: Math.floor(Math.random() * 4) + 6 + ' airbags',
            adas: ['Basic', 'Advanced', 'Premium'][Math.floor(Math.random() * 3)],
            msrp: '$' + (25000 + (carId * 5000)).toLocaleString(),
            destination: '$' + (Math.floor(Math.random() * 500) + 900).toLocaleString(),
            warranty_basic: Math.floor(Math.random() * 3) + 3 + ' years',
            warranty_powertrain: Math.floor(Math.random() * 3) + 5 + ' years'
        };

        // Add to selected cars
        selectedCars[slotNumber] = car;

        // Update the UI
        displayCar(car, slotNumber);

        // Update buy button
        document.querySelector(`.buy-btn-container-${slotNumber}`).classList.remove('d-none');
        document.getElementById(`buy-car-${slotNumber}`).href = `/buy/${car.id}`;
    }

    // Display a car in a specific slot
    function displayCar(car, slotNumber) {
        const slot = document.getElementById(`car-slot-${slotNumber}`);

        // Hide the add button
        slot.querySelector('.car-selection').classList.add('d-none');

        // Show the car data
        const selectedCarElement = slot.querySelector('.selected-car');
        selectedCarElement.classList.remove('d-none');

        // Populate car image and details
        document.getElementById(`car-image-${slotNumber}`).src = car.image_url;
        document.getElementById(`car-name-${slotNumber}`).textContent = car.name;
        document.getElementById(`car-price-${slotNumber}`).textContent = '$' + car.price.toLocaleString();

        // Populate all the other fields
        document.getElementById(`car-engine-${slotNumber}`).textContent = car.engine;
        document.getElementById(`car-horsepower-${slotNumber}`).textContent = car.horsepower;
        document.getElementById(`car-torque-${slotNumber}`).textContent = car.torque;
        document.getElementById(`car-acceleration-${slotNumber}`).textContent = car.acceleration;
        document.getElementById(`car-transmission-${slotNumber}`).textContent = car.transmission;
        document.getElementById(`car-fuel-type-${slotNumber}`).textContent = car.fuel_type;
        document.getElementById(`car-city-mpg-${slotNumber}`).textContent = car.city_mpg;
        document.getElementById(`car-highway-mpg-${slotNumber}`).textContent = car.highway_mpg;
        document.getElementById(`car-fuel-capacity-${slotNumber}`).textContent = car.fuel_capacity;
        document.getElementById(`car-length-${slotNumber}`).textContent = car.length;
        document.getElementById(`car-width-${slotNumber}`).textContent = car.width;
        document.getElementById(`car-height-${slotNumber}`).textContent = car.height;
        document.getElementById(`car-wheelbase-${slotNumber}`).textContent = car.wheelbase;
        document.getElementById(`car-seating-${slotNumber}`).textContent = car.seating;
        document.getElementById(`car-cargo-${slotNumber}`).textContent = car.cargo;
        document.getElementById(`car-infotainment-${slotNumber}`).textContent = car.infotainment;
        document.getElementById(`car-climate-${slotNumber}`).textContent = car.climate;
        document.getElementById(`car-safety-${slotNumber}`).textContent = car.safety;
        document.getElementById(`car-adas-${slotNumber}`).textContent = car.adas;
        document.getElementById(`car-msrp-${slotNumber}`).textContent = car.msrp;
        document.getElementById(`car-destination-${slotNumber}`).textContent = car.destination;
        document.getElementById(`car-warranty-basic-${slotNumber}`).textContent = car.warranty_basic;
        document.getElementById(`car-warranty-powertrain-${slotNumber}`).textContent = car.warranty_powertrain;

        // After all cars are loaded, highlight the best/worst values
        highlightComparisons();
    }

    // Set up event listeners
    function setupEventListeners() {
        // Select car buttons
        document.querySelectorAll('.select-car-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the slot number from the button ID
                currentSlot = parseInt(this.id.replace('select-car-', ''));

                // Show the car selection modal
                if (typeof bootstrap !== 'undefined') {
                    const modal = new bootstrap.Modal(document.getElementById('carSelectionModal'));
                    modal.show();
                }
            });
        });

        // Remove car buttons
        document.querySelectorAll('.remove-car').forEach(button => {
            button.addEventListener('click', function() {
                const slotNumber = parseInt(this.getAttribute('data-slot'));
                removeCar(slotNumber);
            });
        });

        // Car search in modal
        document.getElementById('car-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            document.querySelectorAll('.car-selection-item').forEach(item => {
                const carName = item.querySelector('.card-title').textContent.toLowerCase();

                if (carName.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Handle car selection from modal
    function selectCar(carId, carName, carImage, carPrice) {
        // Hide modal
        bootstrap.Modal.getInstance(document.getElementById('carSelectionModal')).hide();

        if (currentSlot === null) return;

        // In a real app, you would fetch car details from your API
        mockLoadCarData(carId, currentSlot);

        // Update localStorage
        updateLocalStorage();

        // Check if we need to show the comparison container
        checkComparisonVisibility();

        // Reset current slot
        currentSlot = null;
    }

    // Remove a car from comparison
    function removeCar(slotNumber) {
        // Reset car data
        const slot = document.getElementById(`car-slot-${slotNumber}`);
        slot.querySelector('.car-selection').classList.remove('d-none');
        slot.querySelector('.selected-car').classList.add('d-none');

        // Clear all data fields
        document.querySelectorAll(`[id^="car-"][id$="-${slotNumber}"]`).forEach(element => {
            element.textContent = '-';
        });

        // Hide buy button
        document.querySelector(`.buy-btn-container-${slotNumber}`).classList.add('d-none');

        // Remove from selected cars
        delete selectedCars[slotNumber];

        // Update localStorage
        updateLocalStorage();

        // Check if we need to hide the comparison container
        checkComparisonVisibility();

        // Re-highlight comparisons
        highlightComparisons();
    }

    // Update localStorage with current selection
    function updateLocalStorage() {
        const carIds = Object.values(selectedCars).map(car => car.id);
        localStorage.setItem('carComparison', JSON.stringify(carIds));
    }

    // Check if we need to show/hide the comparison container
    function checkComparisonVisibility() {
        const hasSelectedCars = Object.keys(selectedCars).length > 0;

        if (hasSelectedCars) {
            document.getElementById('empty-comparison').classList.add('d-none');
            document.getElementById('comparison-container').classList.remove('d-none');
        } else {
            document.getElementById('empty-comparison').classList.remove('d-none');
            document.getElementById('comparison-container').classList.add('d-none');
        }
    }

    // Highlight best/worst values
    function highlightComparisons() {
        // We only compare numeric values for certain specs
        const compareSpecs = {
            'horsepower': true, // Higher is better
            'torque': true, // Higher is better
            'acceleration': false, // Lower is better
            'city-mpg': true, // Higher is better
            'highway-mpg': true, // Higher is better
            'cargo': true, // Higher is better
        };

        // Process each comparable spec
        Object.keys(compareSpecs).forEach(spec => {
            const isHigherBetter = compareSpecs[spec];
            const values = [];

            // Get all values for this spec
            for (let i = 1; i <= 3; i++) {
                const element = document.getElementById(`car-${spec}-${i}`);
                if (element && element.textContent !== '-') {
                    // Extract numeric value (strip non-digits except decimal point)
                    const value = parseFloat(element.textContent.replace(/[^\d.]/g, ''));
                    if (!isNaN(value)) {
                        values.push({ slot: i, value: value });
                    }
                }
            }

            // Only compare if we have multiple values
            if (values.length > 1) {
                // Sort values
                values.sort((a, b) => isHigherBetter ? b.value - a.value : a.value - b.value);

                // Highlight best and worst
                const bestSlot = values[0].slot;
                const worstSlot = values[values.length - 1].slot;

                // Only highlight if there's a difference
                if (values[0].value !== values[values.length - 1].value) {
                    document.getElementById(`car-${spec}-${bestSlot}`).classList.add('highlight-best');

                    // Only highlight worst if there are more than 2 cars being compared
                    if (values.length > 2) {
                        document.getElementById(`car-${spec}-${worstSlot}`).classList.add('highlight-worst');
                    }
                }
            }
        });
    }
</script>
@endpush
