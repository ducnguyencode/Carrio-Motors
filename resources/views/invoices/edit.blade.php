<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Invoice #{{ $invoice->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">An error occurred!</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('invoices.update', $invoice) }}" method="POST" id="invoiceForm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Information -->
                            <div class="col-span-2 md:col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>

                                <div class="mb-4">
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required value="{{ old('customer_name', $invoice->customer_name) }}">
                                </div>

                                <div class="mb-4">
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                                    <input type="text" name="customer_phone" id="customer_phone" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required value="{{ old('customer_phone', $invoice->customer_phone) }}">
                                </div>

                                <div class="mb-4">
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required value="{{ old('customer_email', $invoice->customer_email) }}">
                                </div>

                                <div class="mb-4">
                                    <label for="customer_address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                                    <textarea name="customer_address" id="customer_address" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('customer_address', $invoice->customer_address) }}</textarea>
                                </div>
                            </div>

                            <!-- Thông tin thanh toán -->
                            <div class="col-span-2 md:col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin thanh toán</h3>

                                <div class="mb-4">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Phương thức thanh toán</label>
                                    <select name="payment_method" id="payment_method" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="cash" {{ old('payment_method', $invoice->payment_method) == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                                        <option value="bank_transfer" {{ old('payment_method', $invoice->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                                        <option value="credit_card" {{ old('payment_method', $invoice->payment_method) == 'credit_card' ? 'selected' : '' }}>Thẻ tín dụng</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="discount_amount" class="block text-sm font-medium text-gray-700">Số tiền giảm giá (VNĐ)</label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('discount_amount', $invoice->discount_amount) }}" min="0">
                                </div>
                            </div>
                        </div>

                        <!-- Danh sách xe -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Danh sách xe</h3>

                            <div id="car-list">
                                @foreach($invoice->details as $index => $detail)
                                    <div class="car-item grid grid-cols-12 gap-4 mb-4">
                                        <div class="col-span-6">
                                            <label class="block text-sm font-medium text-gray-700">Chọn xe</label>
                                            <select name="cars[{{ $index }}][car_id]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                                <option value="">Chọn xe</option>
                                                @foreach($cars as $car)
                                                    <option value="{{ $car->id }}" data-price="{{ $car->price }}" {{ $detail->car_id == $car->id ? 'selected' : '' }}>
                                                        {{ $car->name }} - {{ number_format($car->price, 0, ',', '.') }} VNĐ
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-4">
                                            <label class="block text-sm font-medium text-gray-700">Số lượng</label>
                                            <input type="number" name="cars[{{ $index }}][quantity]" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $detail->quantity }}" min="1" required>
                                        </div>
                                        <div class="col-span-2 flex items-end">
                                            <button type="button" class="remove-car bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" {{ $loop->first && $loop->count == 1 ? 'style=display:none' : '' }}>
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-car" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Thêm xe
                            </button>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('invoices.show', $invoice) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Hủy
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carList = document.getElementById('car-list');
            const addCarBtn = document.getElementById('add-car');
            let carCount = {{ count($invoice->details) }};

            // Thêm xe mới
            addCarBtn.addEventListener('click', function() {
                const carItem = document.querySelector('.car-item').cloneNode(true);

                // Cập nhật các name attribute
                carItem.querySelector('select').name = `cars[${carCount}][car_id]`;
                carItem.querySelector('input[type="number"]').name = `cars[${carCount}][quantity]`;

                // Reset giá trị
                carItem.querySelector('select').value = '';
                carItem.querySelector('input[type="number"]').value = '1';

                // Hiển thị nút xóa
                carItem.querySelector('.remove-car').style.display = 'block';

                carList.appendChild(carItem);
                carCount++;
            });

            // Xóa xe
            carList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-car')) {
                    const items = document.querySelectorAll('.car-item');
                    if (items.length > 1) {
                        e.target.closest('.car-item').remove();
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
