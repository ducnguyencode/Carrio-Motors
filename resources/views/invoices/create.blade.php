<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Invoice
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error occurred!</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>

                                <div class="mb-4">
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required value="{{ old('customer_name') }}">
                                </div>

                                <div class="mb-4">
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="customer_phone" id="customer_phone" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required value="{{ old('customer_phone') }}">
                                </div>

                                <div class="mb-4">
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required value="{{ old('customer_email') }}">
                                </div>

                                <div class="mb-4">
                                    <label for="customer_address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="customer_address" id="customer_address" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('customer_address') }}</textarea>
                                </div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>

                                <div class="mb-4">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="discount_amount" class="block text-sm font-medium text-gray-700">Discount Amount (VND)</label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('discount_amount', 0) }}" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Car List</h3>

                            <div id="car-list">
                                <div class="car-item grid grid-cols-12 gap-4 mb-4">
                                    <div class="col-span-6">
                                        <label class="block text-sm font-medium text-gray-700">Select Car</label>
                                        <select name="cars[0][car_id]" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                            <option value="">Select a car</option>
                                            @foreach($cars as $car)
                                                <option value="{{ $car->id }}" data-price="{{ $car->price }}">
                                                    {{ $car->name }} - {{ number_format($car->price, 0, ',', '.') }} VND
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-4">
                                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <input type="number" name="cars[0][quantity]" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="1" min="1" required>
                                    </div>
                                    <div class="col-span-2 flex items-end">
                                        <button type="button" class="remove-car bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" style="display: none;">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-car" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add Car
                            </button>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('invoices.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Invoice
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
            let carCount = 1;

            addCarBtn.addEventListener('click', function() {
                const carItem = document.querySelector('.car-item').cloneNode(true);

                carItem.querySelector('select').name = `cars[${carCount}][car_id]`;
                carItem.querySelector('input[type="number"]').name = `cars[${carCount}][quantity]`;

                carItem.querySelector('select').value = '';
                carItem.querySelector('input[type="number"]').value = '1';

                carItem.querySelector('.remove-car').style.display = 'block';

                carList.appendChild(carItem);
                carCount++;
            });

            carList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-car')) {
                    e.target.closest('.car-item').remove();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
