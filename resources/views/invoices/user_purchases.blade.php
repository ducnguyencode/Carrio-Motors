@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>My Purchase History</h1>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(count($invoices) > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Car</th>
                                <th>Purchase Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->car_name ?? 'N/A' }}</td>
                                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($invoice->total_price, 2) }}</td>
                                <td>
                                    <span class="badge
                                        @if($invoice->status == 'deposit') bg-warning
                                        @elseif($invoice->status == 'payment' || $invoice->status == 'warehouse') bg-info
                                        @elseif($invoice->status == 'success') bg-success
                                        @elseif($invoice->status == 'cancel') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->id }}">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>

        <!-- Invoice Details Modals -->
        @foreach($invoices as $invoice)
        <div class="modal fade" id="invoiceModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="invoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModalLabel{{ $invoice->id }}">Invoice #{{ $invoice->id }} Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Invoice Information</h6>
                                <p><strong>Invoice ID:</strong> {{ $invoice->id }}</p>
                                <p><strong>Purchase Date:</strong> {{ $invoice->created_at->format('M d, Y H:i') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
                                <p><strong>Payment Method:</strong> {{ ucfirst($invoice->payment_method ?? 'N/A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Car Information</h6>
                                <p><strong>Car:</strong> {{ $invoice->car_name ?? 'N/A' }}</p>
                                <p><strong>Color:</strong> {{ $invoice->color_name ?? 'N/A' }}</p>
                                <p><strong>Price:</strong> ${{ number_format($invoice->total_price, 2) }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Customer Information</h6>
                                <p><strong>Name:</strong> {{ $invoice->customer_name ?? $invoice->buyer_name ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $invoice->customer_phone ?? $invoice->buyer_phone ?? 'N/A' }}</p>
                                <p><strong>Email:</strong> {{ $invoice->customer_email ?? $invoice->buyer_email ?? 'N/A' }}</p>
                                <p><strong>Address:</strong> {{ $invoice->customer_address ?? Auth::user()->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if(!empty($invoice->notes))
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Additional Notes</h6>
                                <p>{{ $invoice->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">
            You haven't made any purchases yet. <a href="{{ route('cars') }}">Browse our cars</a> to get started.
        </div>
    @endif
</div>
@endsection
