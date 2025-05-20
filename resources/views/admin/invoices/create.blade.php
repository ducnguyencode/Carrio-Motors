@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Create New Invoice</h2>
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

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.invoices.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Customer Information -->
                <div>
                    <h5 class="mb-4 text-lg font-semibold">Customer Information</h5>
                    <div class="mb-4">
                        <label for="customer_name" class="block mb-1 font-medium">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('customer_name') border-red-500 @enderror">
                        @error('customer_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="customer_email" class="block mb-1 font-medium">Customer Email</label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('customer_email') border-red-500 @enderror">
                        @error('customer_email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="customer_phone" class="block mb-1 font-medium">Customer Phone</label>
                        <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('customer_phone') border-red-500 @enderror">
                        @error('customer_phone')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="customer_address" class="block mb-1 font-medium">Customer Address</label>
                        <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address') }}" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('customer_address') border-red-500 @enderror">
                        @error('customer_address')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="payment_method" class="block mb-1 font-medium">Payment Method</label>
                        <select id="payment_method" name="payment_method" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 @error('payment_method') border-red-500 @enderror">
                            <option value="">Select Payment Method</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        </select>
                        @error('payment_method')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Car Selection -->
                <div>
                    <h5 class="mb-4 text-lg font-semibold">Car Selection</h5>
                    <div id="carSelections">
                        <div class="car-selection mb-4">
                            <div class="mb-4">
                                <label class="block mb-1 font-medium">Select Car</label>
                                <div class="flex gap-2">
                                    <select name="car_detail_ids[]" required
                                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 car-select @error('car_detail_ids.0') border-red-500 @enderror">
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
                                    <button type="button" class="px-3 py-2 bg-red-500 text-white rounded remove-car hidden">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error('car_detail_ids.*')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block mb-1 font-medium">Quantity</label>
                                <input type="number" name="quantities[]" min="1" value="{{ old('quantities.0', 1) }}" required
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 quantity-input @error('quantities.0') border-red-500 @enderror">
                                @error('quantities.*')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500" id="addCarBtn">
                        <i class="fas fa-plus mr-1"></i> Add Another Car
                    </button>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold flex items-center">
                    <i class="fas fa-save mr-2"></i> Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Show/hide remove button
        function updateRemoveButtons() {
            const selections = $('.car-selection');
            if (selections.length > 1) {
                $('.remove-car').removeClass('hidden');
            } else {
                $('.remove-car').addClass('hidden');
            }
        }

        // Add new car selection
        $('#addCarBtn').click(function() {
            const newSelection = $('.car-selection').first().clone();

            // Reset values
            newSelection.find('select').val('');
            newSelection.find('.quantity-input').val(1);

            // Show remove button
            newSelection.find('.remove-car').removeClass('hidden');

            $('#carSelections').append(newSelection);
            updateRemoveButtons();
        });

        // Remove car selection
        $(document).on('click', '.remove-car', function() {
            $(this).closest('.car-selection').remove();
            updateRemoveButtons();
        });

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

        updateRemoveButtons();
    });
</script>
@endpush
@endsection
