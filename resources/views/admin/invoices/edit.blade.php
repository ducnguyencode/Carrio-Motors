@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Invoice #{{ $invoice->id }}</h1>
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                   value="{{ old('customer_name', $invoice->customer_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_email">Customer Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email"
                                   value="{{ old('customer_email', $invoice->customer_email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_phone">Customer Phone</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                                   value="{{ old('customer_phone', $invoice->customer_phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_address">Customer Address</label>
                            <textarea class="form-control" id="customer_address" name="customer_address"
                                      rows="3" required>{{ old('customer_address', $invoice->customer_address) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ $invoice->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ $invoice->payment_method === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                @foreach($statuses as $key => $value)
                                    <option value="{{ strtolower($key) }}" {{ strtolower(old('status', $invoice->status)) === strtolower($key) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Invoice Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->invoiceDetails as $detail)
                                        <tr>
                                            <td>
                                                {{ $detail->carDetail->car->name }}
                                                <input type="hidden" name="invoice_details[{{ $loop->index }}][id]" value="{{ $detail->id }}">
                                            </td>
                                            <td>{{ $detail->carDetail->carColor->name }}</td>
                                            <td>{{ number_format($detail->price, 2) }}</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm quantity-input"
                                                       name="invoice_details[{{ $loop->index }}][quantity]"
                                                       value="{{ $detail->quantity }}"
                                                       min="1"
                                                       max="{{ $detail->carDetail->quantity + $detail->quantity }}"
                                                       data-price="{{ $detail->price }}"
                                                       required>
                                            </td>
                                            <td class="item-total">{{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                        <td id="grand-total">{{ number_format($invoice->total_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const grandTotalElement = document.getElementById('grand-total');

        function updateTotals() {
            let grandTotal = 0;

            quantityInputs.forEach(input => {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                const total = price * quantity;

                // Update row total
                const row = input.closest('tr');
                row.querySelector('.item-total').textContent = total.toFixed(2);

                grandTotal += total;
            });

            // Update grand total
            grandTotalElement.textContent = grandTotal.toFixed(2);
        }

        quantityInputs.forEach(input => {
            input.addEventListener('change', updateTotals);
            input.addEventListener('input', updateTotals);
        });
    });
</script>
@endpush

@endsection
