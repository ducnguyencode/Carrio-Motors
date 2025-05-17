@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Create New Invoice</h6>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.invoices.store') }}" method="POST">
                @csrf

                <!-- Customer Information -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <div class="form-group mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_email" class="form-label">Customer Email</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_phone" class="form-label">Customer Phone</label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_address" class="form-label">Customer Address</label>
                            <input type="text" class="form-control @error('customer_address') is-invalid @enderror"
                                id="customer_address" name="customer_address" value="{{ old('customer_address') }}" required>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-control @error('payment_method') is-invalid @enderror"
                                id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Car Selection -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Car Selection</h5>
                        <div id="carSelections">
                            <div class="car-selection mb-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Select Car</label>
                                    <div class="input-group">
                                        <select class="form-control car-select @error('car_detail_ids.0') is-invalid @enderror"
                                            name="car_detail_ids[]" required>
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
                                        <button type="button" class="btn btn-danger remove-car" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    @error('car_detail_ids.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control quantity-input @error('quantities.0') is-invalid @enderror"
                                        name="quantities[]" min="1" value="{{ old('quantities.0', 1) }}" required>
                                    @error('quantities.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="addCarBtn">
                            <i class="fas fa-plus"></i> Add Another Car
                        </button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Show/hide remove button
        function updateRemoveButtons() {
            const selections = $('.car-selection');
            if (selections.length > 1) {
                $('.remove-car').show();
            } else {
                $('.remove-car').hide();
            }
        }

        // Add new car selection
        $('#addCarBtn').click(function() {
            const newSelection = $('.car-selection').first().clone();

            // Reset values
            newSelection.find('select').val('');
            newSelection.find('.quantity-input').val(1);

            // Show remove button
            newSelection.find('.remove-car').show();

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
            if ($(this).val()) {
                $(this).trigger('change');
            }
        });

        // Form validation before submit
        $('form').on('submit', function(e) {
            let isValid = true;

            // Check if at least one car is selected
            $('.car-select').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Please select a car');
                    isValid = false;
                }
            });

            // Check quantities
            $('.quantity-input').each(function() {
                const val = parseInt($(this).val());
                const max = parseInt($(this).attr('max'));

                if (!val || val < 1) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Quantity must be at least 1');
                    isValid = false;
                } else if (max && val > max) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text(`Maximum quantity is ${max}`);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection
