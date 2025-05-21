@extends('layouts.app')

@section('title')
Purchase {{ $car->name }} | Carrio Motors
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .purchase-container {
        padding-top: 2rem;
        padding-bottom: 3rem;
    }

    .purchase-header {
        position: relative;
        background: linear-gradient(135deg, #0d2c54, #175d8e);
        color: #fff;
        padding: 3rem 0;
        border-radius: 12px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .purchase-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxkZWZzPgogICAgICAgIDxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPgogICAgICAgICAgICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9InJnYmEoMjU1LCAyNTUsIDI1NSwgMC4wNSkiLz4KICAgICAgICA8L3BhdHRlcm4+CiAgICA8L2RlZnM+CiAgICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIiAvPgo8L3N2Zz4=');
        opacity: 0.2;
    }

    .purchase-car-title {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .purchase-subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        margin-bottom: 0;
        opacity: 0.9;
    }

    .car-image-container {
        position: relative;
        height: 300px;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .car-image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .car-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .car-info-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: none;
    }

    .car-info-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .car-info-header {
        padding: 1.5rem;
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .price-tag {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .specs-list {
        list-style-type: none;
        padding-left: 0;
    }

    .specs-list li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
    }

    .specs-list li:last-child {
        border-bottom: none;
    }

    .specs-list li i {
        margin-right: 0.75rem;
        color: #3498db;
        width: 20px;
        text-align: center;
    }

    .form-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .form-card-header {
        padding: 1.5rem;
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #e1e5ea;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .form-label {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #495057;
    }

    .color-preview {
        display: inline-block;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        margin-right: 0.5rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
        vertical-align: middle;
    }

    .btn-primary {
        background-color: #2c3e50;
        border-color: #2c3e50;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(44, 62, 80, 0.15);
    }

    .btn-primary:hover {
        background-color: #1a252f;
        border-color: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(44, 62, 80, 0.25);
    }

    .btn-outline-secondary {
        border-color: #cbd5e1;
        color: #64748b;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .btn-outline-secondary:hover {
        background-color: #f8fafc;
        color: #1e293b;
        border-color: #94a3b8;
    }

    /* Payment method styling */
    .payment-option {
        padding: 1rem;
        border: 1px solid #e1e5ea;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .payment-option:hover {
        border-color: #b0bec5;
        background-color: #f9fafb;
    }

    .payment-option.selected {
        border-color: #3498db;
        background-color: rgba(52, 152, 219, 0.05);
    }

    .payment-option input {
        margin-right: 1rem;
    }

    .payment-logo {
        margin-left: auto;
        height: 24px;
    }

    .success-animation {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .step-number {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #3498db;
        color: white;
        font-weight: bold;
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
<div class="container purchase-container">
    <div class="purchase-header text-center">
        <div class="container">
            <h1 class="purchase-car-title">{{ $car->name }}</h1>
            <p class="purchase-subtitle">Complete your purchase information</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 order-lg-1 order-2">
            <div class="card form-card mb-4">
                <div class="form-card-header">
                    <h3 class="mb-0"><span class="step-number">1</span>Customer Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('buy.process') }}" method="POST" id="purchaseForm">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        <input type="hidden" name="car_detail_id" value="{{ $selectedDetail->id ?? '' }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="additional_info" class="form-label">Additional Information</label>
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="3" placeholder="Notes or special requests..."></textarea>
                        </div>

                        <div class="form-card-header mt-4">
                            <h3 class="mb-0"><span class="step-number">2</span>Purchase Information</h3>
                        </div>

                        <div class="mb-3 mt-4">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $selectedDetail->quantity ?? 10 }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Payment Method</label>

                            <div class="payment-option" onclick="selectPayment('bank_transfer')">
                                <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" checked>
                                <label for="bank_transfer" class="mb-0">Bank Transfer</label>
                                <img src="https://cdn-icons-png.flaticon.com/512/2168/2168766.png" alt="Bank Transfer" class="payment-logo">
                            </div>

                            <div class="payment-option" onclick="selectPayment('credit_card')">
                                <input type="radio" name="payment_method" id="credit_card" value="credit_card">
                                <label for="credit_card" class="mb-0">Credit Card / Debit Card</label>
                                <img src="https://cdn-icons-png.flaticon.com/512/179/179457.png" alt="Credit Card" class="payment-logo">
                            </div>

                            <div class="payment-option" onclick="selectPayment('cash')">
                                <input type="radio" name="payment_method" id="cash" value="cash">
                                <label for="cash" class="mb-0">Cash on Delivery</label>
                                <img src="https://cdn-icons-png.flaticon.com/512/639/639365.png" alt="Cash" class="payment-logo">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Complete Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 order-lg-2 order-1 mb-4 mb-lg-0">
            <div class="car-image-container mb-4">
                <img src="{{ $selectedDetail && $selectedDetail->main_image ? asset($selectedDetail->main_image) : ($car->main_image ? asset('storage/' . $car->main_image) : asset('images/cars/default.jpg')) }}"
                     alt="{{ $car->name }}" class="car-image">
            </div>

            <div class="card car-info-card mb-4">
                <div class="car-info-header">
                    <h3 class="mb-0">Car Information</h3>
                </div>
                <div class="card-body">
                    <div class="price-tag">
                        ${{ number_format($selectedDetail->price ?? $car->price, 2) }}
                    </div>

                    @if($selectedDetail && $selectedDetail->carColor)
                    <div class="selected-color mb-3">
                        <strong>Color:</strong>
                        <span class="color-preview" style="background-color: {{ $selectedDetail->carColor->hex_code }};"></span>
                        {{ $selectedDetail->carColor->name }}
                    </div>
                    @endif

                    <ul class="specs-list">
                        <li>
                            <i class="bi bi-speedometer2"></i>
                            <span>{{ $car->engine->name ?? 'N/A' }}</span>
                        </li>
                        <li>
                            <i class="bi bi-fuel-pump"></i>
                            <span>{{ $car->fuel_type ?? 'Petrol' }}</span>
                        </li>
                        <li>
                            <i class="bi bi-gear"></i>
                            <span>{{ $car->transmission }}</span>
                        </li>
                        <li>
                            <i class="bi bi-people"></i>
                            <span>{{ $car->seat_number }} seats</span>
                        </li>
                        <li>
                            <i class="bi bi-calendar3"></i>
                            <span>Year: {{ date('Y') }}</span>
                        </li>
                        <li>
                            <i class="bi bi-truck"></i>
                            <span>Free delivery</span>
                        </li>
                    </ul>

                    <div class="alert alert-info mt-3 mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Complete your information to purchase the car. Our staff will contact you within 24 hours.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="success-animation">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h3>Order Successful!</h3>
                    <p class="mb-4">Thank you for your purchase at Carrio Motors. We have sent a confirmation email to your email address.</p>
                    <div class="d-grid">
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectPayment(method) {
        // Remove selected class from all options
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('selected');
        });

        // Add selected class to the clicked option
        document.querySelector(`.payment-option:has(#${method})`).classList.add('selected');

        // Check the radio button
        document.getElementById(method).checked = true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the first payment option as selected
        selectPayment('bank_transfer');

        // Form submission handling
        const form = document.getElementById('purchaseForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Here you would normally submit the form data via AJAX
            // For demo purposes, we'll just show the success modal
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // You can implement actual form submission here
            // const formData = new FormData(form);
            // fetch('/buy/process', {
            //     method: 'POST',
            //     body: formData
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         successModal.show();
            //     }
            // });
        });
    });
</script>
@endsection
