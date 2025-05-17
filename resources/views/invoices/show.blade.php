@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Order Details #{{ $invoice->id }}</h2>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Name:</label>
                        <p>{{ $invoice->customer_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Email:</label>
                        <p>{{ $invoice->customer_email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Phone:</label>
                        <p>{{ $invoice->customer_phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Delivery Address:</label>
                        <p>{{ $invoice->customer_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Order Date:</label>
                        <p>{{ $invoice->purchase_date->format('m/d/Y h:i A') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Payment Method:</label>
                        <p>{{ ucfirst($invoice->payment_method) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Status:</label>
                        <span class="badge
                            @if($invoice->status == 'pending') bg-warning
                            @elseif($invoice->status == 'recheck') bg-info
                            @elseif($invoice->status == 'done') bg-success
                            @elseif($invoice->status == 'cancel') bg-danger
                            @endif">
                            @switch($invoice->status)
                                @case('pending')
                                    Pending
                                    @break
                                @case('recheck')
                                    Recheck
                                    @break
                                @case('done')
                                    Done
                                    @break
                                @case('cancel')
                                    Cancelled
                                    @break
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Ordered Cars</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->details as $detail)
                            <tr>
                                <td>{{ $detail->car->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>${{ number_format($detail->price, 2) }}</td>
                                <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold">${{ number_format($invoice->total_price, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @if($invoice->status == 'deposit' || $invoice->status == 'paid')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle"></i>
                If you need to make any changes to your order or have any questions, please contact our customer service.
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
