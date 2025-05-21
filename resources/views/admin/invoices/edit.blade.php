@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Edit Invoice #{{ $invoice->id }}</h2>
            <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                <ul class="mb-0 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

            <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Customer Information -->
                <div>
                    <h5 class="mb-4 text-lg font-semibold">Customer Information</h5>
                    <div class="mb-4">
                        <label for="customer_name" class="block mb-1 font-medium">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $invoice->customer_name) }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    <div class="mb-4">
                        <label for="customer_email" class="block mb-1 font-medium">Customer Email</label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $invoice->customer_email) }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    <div class="mb-4">
                        <label for="customer_phone" class="block mb-1 font-medium">Customer Phone</label>
                        <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $invoice->customer_phone) }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    <div class="mb-4">
                        <label for="customer_address" class="block mb-1 font-medium">Customer Address</label>
                        <textarea id="customer_address" name="customer_address" rows="3" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('customer_address', $invoice->customer_address) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="seller_tax_code" class="block mb-1 font-medium">Seller Tax Code</label>
                        <input type="text" id="seller_tax_code" name="seller_tax_code" value="{{ old('seller_tax_code', $invoice->seller_tax_code) }}" readonly
                            class="w-full px-3 py-2 border rounded bg-gray-100 focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">Fixed for all invoices</p>
                    </div>
                    <div class="mb-4">
                        <label for="customer_tax_code" class="block mb-1 font-medium">Customer Tax Code (Optional)</label>
                        <input type="text" id="customer_tax_code" name="customer_tax_code" value="{{ old('customer_tax_code', $invoice->customer_tax_code) }}"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="tax_rate" class="block mb-1 font-medium">Tax Rate (%)</label>
                        <input type="number" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', $invoice->tax_rate) }}" step="0.01" min="0" max="100"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label for="payment_method" class="block mb-1 font-medium">Payment Method</label>
                        <select id="payment_method" name="payment_method" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ $invoice->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ $invoice->payment_method === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            </select>
                        </div>
                    <div class="mb-4">
                        <label for="status" class="block mb-1 font-medium">Status</label>
                        <select id="status" name="status" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @foreach($statuses as $key => $value)
                                    <option value="{{ strtolower($key) }}" {{ strtolower(old('status', $invoice->status)) === strtolower($key) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    <div class="mb-4">
                        <label for="user_id" class="block mb-1 font-medium">Linked User Account</label>
                        <select id="user_id" name="user_id"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">None (No user account linked)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $invoice->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Link this invoice to a user account for purchase history</p>
                    </div>
                    </div>

                    <!-- Invoice Details -->
                <div>
                    <h5 class="mb-4 text-lg font-semibold">Invoice Details</h5>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                    <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Car</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    </tr>
                                </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($invoice->invoiceDetails as $detail)
                                        <tr>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                                {{ $detail->carDetail->car->name }}
                                                <input type="hidden" name="invoice_details[{{ $loop->index }}][id]" value="{{ $detail->id }}">
                                            </td>
                                        <td class="px-3 py-2 whitespace-nowrap">{{ $detail->carDetail->carColor->name }}</td>
                                        <td class="px-3 py-2 whitespace-nowrap">${{ number_format($detail->price, 2) }}</td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            <input type="number"
                                                class="w-20 px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 quantity-input"
                                                       name="invoice_details[{{ $loop->index }}][quantity]"
                                                       value="{{ $detail->quantity }}"
                                                       min="1"
                                                       max="{{ $detail->carDetail->quantity + $detail->quantity }}"
                                                       data-price="{{ $detail->price }}"
                                                       required>
                                            </td>
                                        <td class="px-3 py-2 whitespace-nowrap item-total">${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <td colspan="4" class="px-3 py-2 text-right"><strong>Total:</strong></td>
                                    <td class="px-3 py-2" id="grand-total">${{ number_format($invoice->total_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold flex items-center">
                    <i class="fas fa-save mr-2"></i> Update Invoice
                        </button>
                </div>
            </form>
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
                row.querySelector('.item-total').textContent = '$' + total.toFixed(2);

                grandTotal += total;
            });

            // Update grand total
            grandTotalElement.textContent = '$' + grandTotal.toFixed(2);
        }

        quantityInputs.forEach(input => {
            input.addEventListener('change', updateTotals);
            input.addEventListener('input', updateTotals);
        });
    });
</script>
@endpush

@endsection
