@extends('layouts.app')

@section('title')
Order Confirmed | Carrio Motors
@endsection

@section('styles')
<style>
    .success-container {
        padding: 4rem 0;
    }

    .success-card {
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: none;
    }

    .success-header {
        background: linear-gradient(135deg, #0d2c54, #175d8e);
        padding: 2rem 0;
        color: white;
        position: relative;
    }

    .success-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 0;
        right: 0;
        height: 40px;
        background: white;
        border-radius: 50% 50% 0 0;
    }

    .check-icon {
        width: 80px;
        height: 80px;
        background-color: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .check-icon i {
        color: white;
        font-size: 40px;
    }

    .success-title {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .success-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .order-number {
        font-weight: 700;
        color: #28a745;
        font-size: 1.25rem;
    }

    .order-details {
        padding: 2rem;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .order-details h4 {
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.75rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .detail-label {
        font-weight: 500;
        color: #6c757d;
    }

    .detail-value {
        font-weight: 600;
        text-align: right;
    }

    .total-row {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .total-label {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .total-value {
        font-weight: 700;
        font-size: 1.2rem;
        color: #0d2c54;
    }

    .actions {
        margin-top: 2rem;
    }

    .success-message {
        font-size: 1.1rem;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')
<div class="container success-container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card success-card">
                <div class="success-header text-center">
                    <div class="check-icon">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h1 class="success-title">Order Successful!</h1>
                    <p class="success-subtitle">Thank you for purchasing from Carrio Motors</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <p class="success-message">
                            Your order has been confirmed. We've sent a confirmation email to <strong>{{ $order['email'] }}</strong>.
                            <br>Our staff will contact you within 24 hours to confirm details.
                        </p>
                        <p class="order-number mt-3">
                            Order ID: #{{ $order['order_id'] }}
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="order-details">
                                <h4>Order Details</h4>

                                <div class="detail-row">
                                    <div class="detail-label">Car</div>
                                    <div class="detail-value">{{ $order['car'] }}</div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-label">Color</div>
                                    <div class="detail-value">{{ $order['color'] }}</div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-label">Quantity</div>
                                    <div class="detail-value">{{ $order['quantity'] }}</div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-label">Unit Price</div>
                                    <div class="detail-value">${{ $order['price'] }}</div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-label">Payment Method</div>
                                    <div class="detail-value">{{ $order['payment_method'] }}</div>
                                </div>

                                <div class="detail-row total-row">
                                    <div class="total-label">Total</div>
                                    <div class="total-value">${{ $order['total'] }}</div>
                                </div>
                            </div>

                            <div class="actions d-grid gap-3">
                                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Return to Home</a>
                                <a href="{{ route('cars') }}" class="btn btn-outline-primary">Browse Other Cars</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
