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
                            class="select2-user w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
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
                                    class="select2-car w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
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
        // Dữ liệu xe
        const carData = [
            @foreach($carDetails as $carDetail)
            {
                id: {{ $carDetail->id }},
                name: "{{ $carDetail->car_name }}",
                model: "{{ $carDetail->model_name }}",
                engine: "{{ $carDetail->engine_name }}",
                color: "{{ $carDetail->color_name }}",
                price: {{ $carDetail->price }},
                quantity: {{ $carDetail->quantity }},
                searchText: "{{ strtolower($carDetail->car_name . ' ' . $carDetail->model_name . ' ' . $carDetail->engine_name . ' ' . $carDetail->color_name . ' ' . $carDetail->price) }}"
            },
            @endforeach
        ];

        // Dữ liệu người dùng
        const userData = [
            @foreach($users as $user)
            {
                id: {{ $user->id }},
                name: "{{ $user->name }}",
                email: "{{ $user->email }}",
                searchText: "{{ strtolower($user->name . ' ' . $user->email) }}"
            },
            @endforeach
        ];

        // Xử lý tìm kiếm xe
        $("#car_search").on("input", function() {
            const searchText = $(this).val().toLowerCase();

            if (searchText.length < 2) {
                $("#car_results").addClass('hidden');
                return;
            }

            const results = carData.filter(car => car.searchText.includes(searchText));
            displayCarResults(results);
        });

        // Hiển thị kết quả tìm kiếm xe
        function displayCarResults(results) {
            const resultsContainer = $("#car_results");
            resultsContainer.empty();

            if (results.length === 0) {
                resultsContainer.append('<div class="p-3 text-center text-gray-500">No cars found</div>');
            } else {
                results.forEach(car => {
                    const resultItem = $(`
                        <div class="search-result-item" data-id="${car.id}" tabindex="0">
                            <div class="item-name">${car.name}</div>
                            <div class="item-detail">${car.model} - ${car.engine} - ${car.color}</div>
                            <div class="d-flex justify-content-between">
                                <span class="item-price">$${car.price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                <span class="item-detail">(${car.quantity} available)</span>
                            </div>
                        </div>
                    `);

                    resultItem.on('click', function() {
                        selectCar(car);
                    });

                    resultItem.on('keydown', function(e) {
                        if (e.key === 'Enter') {
                            selectCar(car);
                        }
                    });

                    resultsContainer.append(resultItem);
                });
            }

            resultsContainer.removeClass('hidden');
        }

        // Chọn xe
        function selectCar(car) {
            // Cập nhật input ẩn với ID xe
            $("#car_detail_id").val(car.id);

            // Hiển thị thông tin xe đã chọn
            $("#car_name").text(car.name);
            $("#car_details").text(`${car.model} - ${car.engine} - ${car.color}`);
            $("#car_price").text(`$${car.price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);
            $("#car_quantity").text(`${car.quantity} available`);

            // Cập nhật ô tìm kiếm
            $("#car_search").val(`${car.name} - ${car.model}`);

            // Hiển thị thông tin chi tiết và ẩn kết quả tìm kiếm
            $("#selected_car_info").removeClass('hidden');
            $("#car_results").addClass('hidden');

            // Cập nhật giá trị tối đa cho input số lượng
            $("#quantities").attr('max', car.quantity);
            if (parseInt($("#quantities").val()) > car.quantity) {
                $("#quantities").val(car.quantity);
            }
        }

        // Xử lý tìm kiếm người dùng
        $("#user_search").on("input", function() {
            const searchText = $(this).val().toLowerCase();

            if (searchText.length < 2) {
                $("#user_results").addClass('hidden');
                return;
            }

            const results = userData.filter(user => user.searchText.includes(searchText));
            displayUserResults(results);
        });

        // Hiển thị kết quả tìm kiếm người dùng
        function displayUserResults(results) {
            const resultsContainer = $("#user_results");
            resultsContainer.empty();

            if (results.length === 0) {
                resultsContainer.append('<div class="p-3 text-center text-gray-500">No users found</div>');
            } else {
                results.forEach(user => {
                    const resultItem = $(`
                        <div class="search-result-item" data-id="${user.id}" tabindex="0">
                            <div class="item-name">${user.name}</div>
                            <div class="item-detail">${user.email}</div>
                        </div>
                    `);

                    resultItem.on('click', function() {
                        selectUser(user);
                    });

                    resultItem.on('keydown', function(e) {
                        if (e.key === 'Enter') {
                            selectUser(user);
                        }
                    });

                    resultsContainer.append(resultItem);
                });
            }

            resultsContainer.removeClass('hidden');
        }

        // Chọn người dùng
        function selectUser(user) {
            // Cập nhật input ẩn với ID người dùng
            $("#user_id_hidden").val(user.id);

            // Hiển thị thông tin người dùng đã chọn
            $("#user_name").text(user.name);
            $("#user_email").text(user.email);

            // Cập nhật ô tìm kiếm
            $("#user_search").val(user.name);

            // Hiển thị thông tin chi tiết và ẩn kết quả tìm kiếm
            $("#selected_user_info").removeClass('hidden');
            $("#user_results").addClass('hidden');
        }

        // Xử lý khi click ra ngoài kết quả tìm kiếm
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.relative').length) {
                $("#car_results").addClass('hidden');
                $("#user_results").addClass('hidden');
            }
        });

        // Chọn xe từ dữ liệu cũ (nếu có)
        const oldCarId = "{{ old('car_detail_ids.0') }}";
        if (oldCarId) {
            const selectedCar = carData.find(car => car.id == oldCarId);
            if (selectedCar) {
                selectCar(selectedCar);
            }
        }

        // Chọn người dùng từ dữ liệu cũ (nếu có)
        const oldUserId = "{{ old('user_id') }}";
        if (oldUserId) {
            const selectedUser = userData.find(user => user.id == oldUserId);
            if (selectedUser) {
                selectUser(selectedUser);
            }
        }

        // Initialize Select2 for car selection dropdown
        $('.select2-car').select2({
            placeholder: "Search and select a car",
            allowClear: true,
            width: '100%',
            templateResult: formatCarOption,
            escapeMarkup: function(markup) {
                return markup;
            },
            dropdownParent: $('.car-selection')
        });

        // Initialize Select2 for user account dropdown
        $('.select2-user').select2({
            placeholder: "Search and select a user account",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#user_id').parent()
        });

        // Format car options to show more details
        function formatCarOption(car) {
            if (!car.id) {
                return car.text; // Return placeholder text as-is
            }

            // Get data attributes
            const $option = $(car.element);
            const price = $option.data('price');
            const maxQuantity = $option.data('max');

            // Split car text into parts
            const parts = car.text.split(' - ');
            const carName = parts[0];
            const modelName = parts[1];
            const engineName = parts[2];
            const colorName = parts[3];

            // Format price to show commas
            const formattedPrice = price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // Get color box based on color name
            const colorBoxStyle = getColorBoxStyle(colorName);

            // Create custom HTML for the option with separate color box
            const template = `
                <div class="car-option">
                    <div class="car-name">${carName}</div>
                    <div class="car-specs">
                        <span>${modelName}</span>
                        <span>${engineName}</span>
                        <span>
                            <span class="color-box" style="${colorBoxStyle}"></span>
                            ${colorName}
                        </span>
                    </div>
                    <div class="car-bottom">
                        <div class="car-price">$${formattedPrice}</div>
                        <div class="car-stock">${maxQuantity} available</div>
                    </div>
                </div>
            `;

            return template;
        }

        // Function to determine color style based on color name
        function getColorBoxStyle(colorName) {
            const colorLower = colorName ? colorName.toLowerCase().trim() : '';
            let backgroundColor = '#777777'; // Default gray

            if (colorLower.includes('black')) backgroundColor = '#000000';
            else if (colorLower.includes('white')) backgroundColor = '#ffffff';
            else if (colorLower.includes('red')) backgroundColor = '#dc2626';
            else if (colorLower.includes('blue')) backgroundColor = '#2563eb';
            else if (colorLower.includes('green')) backgroundColor = '#059669';
            else if (colorLower.includes('yellow')) backgroundColor = '#fbbf24';
            else if (colorLower.includes('orange')) backgroundColor = '#ea580c';
            else if (colorLower.includes('purple')) backgroundColor = '#7c3aed';
            else if (colorLower.includes('pink')) backgroundColor = '#db2777';
            else if (colorLower.includes('brown')) backgroundColor = '#78350f';
            else if (colorLower.includes('grey') || colorLower.includes('gray')) backgroundColor = '#6b7280';
            else if (colorLower.includes('silver')) backgroundColor = '#d1d5db';
            else if (colorLower.includes('gold')) backgroundColor = '#fbbf24';

            return `background-color: ${backgroundColor}; border: 1px solid #00000033;`;
        }

        // Update quantity max based on available stock when car selection changes
        $('.select2-car').on('change', function() {
            const selected = $('option:selected', this);
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
        $('.select2-car').each(function() {
            const selected = $('option:selected', this);
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

@section('styles')
<style>
    /* Ẩn các option không khớp với tìm kiếm */
    .option-hidden {
        display: none;
    }

    /* Kiểu dáng cho kết quả tìm kiếm */
    .search-result-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }

    .search-result-item:hover,
    .search-result-item:focus {
        background-color: #f3f4f6;
    }

    .search-result-item .item-name {
        font-weight: 500;
    }

    .search-result-item .item-detail {
        font-size: 0.8rem;
        color: #6b7280;
    }

    .search-result-item .item-price {
        color: #047857;
        font-weight: 500;
    }

    /* Custom styling for Select2 dropdowns */
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 5px;
        border-color: #d1d5db;
        border-radius: 0.375rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 26px;
        color: #111827;
    }

    /* Fix for highlight colors in Select2 */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #f3f4f6 !important;
        color: #111827 !important;
    }

    .select2-dropdown {
        border-color: #d1d5db;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .select2-search--dropdown .select2-search__field {
        padding: 8px;
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-results__option {
        padding: 8px 12px;
    }

    /* Car option template */
    .car-option {
        padding: 6px 0;
    }

    .car-option .car-name {
        font-weight: bold;
        margin-bottom: 2px;
    }

    .car-option .car-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 2px;
    }

    .car-option .car-specs span {
        background-color: #f3f4f6;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
    }

    .car-option .car-bottom {
        display: flex;
        justify-content: space-between;
    }

    .car-option .car-price {
        color: #059669;
        font-weight: 600;
    }

    .car-option .car-stock {
        color: #6b7280;
        font-size: 12px;
    }

    /* Color box styling */
    .color-box {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 3px;
        margin-right: 5px;
        vertical-align: middle;
    }
</style>
@endsection
@endsection
