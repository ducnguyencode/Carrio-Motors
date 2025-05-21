@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-2">My Purchase History</h1>
            <p class="text-muted">View all your past orders and their details</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(count($invoices) > 0)
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice #</th>
                                <th>Purchase Date</th>
                                <th>Car Model</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td><strong>{{ $invoice->id }}</strong></td>
                                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($invoice->invoiceDetails && $invoice->invoiceDetails->isNotEmpty())
                                        {{ $invoice->invoiceDetails->first()->carDetail->car->name ?? 'N/A' }}
                                        @if($invoice->invoiceDetails->count() > 1)
                                            <span class="badge bg-info text-white">+{{ $invoice->invoiceDetails->count() - 1 }} more</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>${{ number_format($invoice->total_price, 2) }}</td>
                                <td>
                                    <span class="badge
                                        @if($invoice->status == 'pending') bg-warning text-dark
                                        @elseif($invoice->status == 'recheck') bg-info text-white
                                        @elseif($invoice->status == 'done') bg-success
                                        @elseif($invoice->status == 'cancel') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->id }}">
                                        <i class="bi bi-eye me-1"></i> View Details
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
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="invoiceModalLabel{{ $invoice->id }}">Invoice #{{ $invoice->id }} Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Invoice Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td width="40%">Invoice Number:</td>
                                            <td><strong>#{{ $invoice->id }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Purchase Date:</td>
                                            <td>{{ $invoice->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td>
                                                <span class="badge
                                                    @if($invoice->status == 'pending') bg-warning text-dark
                                                    @elseif($invoice->status == 'recheck') bg-info text-white
                                                    @elseif($invoice->status == 'done') bg-success
                                                    @elseif($invoice->status == 'cancel') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payment Method:</td>
                                            <td>{{ ucfirst($invoice->payment_method ?? 'N/A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Customer Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td width="40%">Name:</td>
                                            <td>{{ $invoice->customer_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td>{{ $invoice->customer_phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>{{ $invoice->customer_email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td>{{ $invoice->customer_address ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mt-4 mb-3">Purchased Items</h6>
                        @if($invoice->invoiceDetails && $invoice->invoiceDetails->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Car</th>
                                            <th>Color</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->invoiceDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->carDetail->car->name ?? 'N/A' }}</td>
                                            <td>
                                                @if($detail->carDetail->carColor)
                                                <div class="d-flex align-items-center">
                                                    <span class="color-dot me-2" style="display: inline-block; width: 15px; height: 15px; border-radius: 50%; background-color: {{ $detail->carDetail->carColor->hex_code ?? '#ccc' }}; border: 1px solid #ddd;"></span>
                                                    {{ $detail->carDetail->carColor->name ?? 'N/A' }}
                            </div>
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>${{ number_format($detail->price, 2) }}</td>
                                            <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                            <td>${{ number_format($invoice->total_price, 2) }}</td>
                                        </tr>
                                        @if(isset($invoice->tax_rate) && isset($invoice->tax_amount))
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Tax ({{ $invoice->tax_rate }}%):</strong></td>
                                            <td>${{ number_format($invoice->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                            <td>${{ number_format($invoice->total_price + $invoice->tax_amount, 2) }}</td>
                                        </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">No item details available for this invoice.</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i> You haven't made any purchases yet. <a href="{{ route('cars') }}" class="alert-link">Browse our cars</a> to get started.
        </div>
    @endif
</div>
@endsection
