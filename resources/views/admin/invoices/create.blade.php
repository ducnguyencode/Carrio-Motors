@extends('admin.layouts.app')

@section('title', 'Create Invoice')

@section('page-heading', 'Create Invoice')

@php
    // Set flag to prevent duplicate flash messages from layout
    $hideFlashMessages = true;
@endphp

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Create New Invoice</h2>
        <a href="{{ route('admin.invoices.index') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded flex justify-between items-center">
            <div>
                <ul class="mb-0 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    <form action="{{ route('admin.invoices.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <h3 class="text-md font-semibold border-b pb-2 mb-4">Customer Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="customer_name" class="block mb-1 text-sm font-medium">Customer Name</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div class="mb-4">
                            <label for="customer_email" class="block mb-1 text-sm font-medium">Customer Email</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="customer_phone" class="block mb-1 text-sm font-medium">Customer Phone</label>
                            <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="block mb-1 text-sm font-medium">Payment Method</label>
                            <select id="payment_method" name="payment_method" required
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="customer_address" class="block mb-1 text-sm font-medium">Customer Address</label>
                        <textarea id="customer_address" name="customer_address" rows="2" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('customer_address') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block mb-1 text-sm font-medium">Link to User Account (Optional)</label>
                        <select id="user_id" name="user_id"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Select User Account</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Link this invoice to a user account for purchase history</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-md font-semibold border-b pb-2 mb-4">Tax Information</h3>

                    <div class="mb-4">
                        <label for="seller_tax_code" class="block mb-1 text-sm font-medium">Seller Tax Code</label>
                        <input type="text" id="seller_tax_code" name="seller_tax_code" value="{{ old('seller_tax_code', '0123456789') }}" readonly
                            class="w-full px-3 py-2 border rounded bg-gray-100 focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">Fixed for all invoices</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="customer_tax_code" class="block mb-1 text-sm font-medium">Customer Tax Code (Optional)</label>
                            <input type="text" id="customer_tax_code" name="customer_tax_code" value="{{ old('customer_tax_code') }}"
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div class="mb-4">
                            <label for="tax_rate" class="block mb-1 text-sm font-medium">Tax Rate (%)</label>
                            <input type="number" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', 10.00) }}" step="0.01" min="0" max="100"
                                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <h3 class="text-md font-semibold border-b pb-2 mb-4">Car Selection</h3>

                    <div id="carSelections">
                        <div class="car-selection bg-gray-50 p-4 rounded border mb-4">
                            <div class="mb-4">
                                <label for="car_detail_ids" class="block mb-1 text-sm font-medium">Select Car</label>
                                <select name="car_detail_ids[]" id="car_detail_ids" required
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 car-select">
                                    <option value="">Select a Car</option>
                                    @foreach($carDetails as $carDetail)
                                        <option value="{{ $carDetail->id }}"
                                            data-price="{{ $carDetail->price }}"
                                            data-max="{{ $carDetail->quantity }}"
                                            {{ old('car_detail_ids.0') == $carDetail->id ? 'selected' : '' }}>
                                            {{ $carDetail->car_name }} -
                                            {{ $carDetail->model_name }} -
                                            {{ $carDetail->engine_name }} -
                                            {{ $carDetail->color_name }} -
                                            ${{ number_format($carDetail->price, 2) }}
                                            ({{ $carDetail->quantity }} available)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="quantities" class="block mb-1 text-sm font-medium">Quantity</label>
                                <input type="number" id="quantities" name="quantities[]" min="1" value="{{ old('quantities.0', 1) }}" required
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 quantity-input">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded border">
                        <h4 class="text-sm font-medium mb-2">Invoice Summary</h4>
                        <div class="text-sm text-gray-600">
                            <p>Select a car from the dropdown above to see the invoice summary.</p>
                            <p class="mt-2">The tax will be calculated automatically based on the tax rate.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="flex items-center gap-1 px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
                <i class="fas fa-save"></i> Create Invoice
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Update quantity max based on available stock
        $(document).on('change', '.car-select', function() {
            const selected = $(this).find(':selected');
            const maxQuantity = selected.data('max');
            const container = $(this).closest('.car-selection');
            const quantityInput = container.find('.quantity-input');

            if (selected.val()) {
                quantityInput.attr('max', maxQuantity);
                if (parseInt(quantityInput.val()) > maxQuantity) {
                    quantityInput.val(maxQuantity);
                }
            } else {
                quantityInput.attr('max', '');
            }
        });

        // Initialize max quantities for pre-selected cars
        $('.car-select').each(function() {
            const selected = $(this).find(':selected');
            const maxQuantity = selected.data('max');
            const container = $(this).closest('.car-selection');
            const quantityInput = container.find('.quantity-input');
            if (selected.val()) {
                quantityInput.attr('max', maxQuantity);
            }
        });
    });
</script>
@endpush
@endsection
