@extends('admin.layouts.app')

@section('title', 'Edit Car Detail')

@section('page-heading', 'Edit Car Detail')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.car_details.update', $carDetail) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car -->
            <div>
                <label for="car_id" class="block text-sm font-semibold text-gray-700 mb-1">Car <span class="text-red-500">*</span></label>
                <select name="car_id" id="car_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('car_id') border-red-500 @enderror" required>
                    <option value="">Select a car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id', $carDetail->car_id) == $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->model->make->name ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color -->
            <div>
                <label for="car_color_id" class="block text-sm font-semibold text-gray-700 mb-1">Color <span class="text-red-500">*</span></label>
                <select name="car_color_id" id="car_color_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('car_color_id') border-red-500 @enderror" required>
                    <option value="">Select a color</option>
                    @foreach($carColors as $color)
                        <option value="{{ $color->id }}" {{ old('car_color_id', $carDetail->color_id) == $color->id ? 'selected' : '' }} style="background-color: {{ $color->hex_code ?? '#fff' }}">
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
                @error('car_color_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $carDetail->quantity) }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('quantity') border-red-500 @enderror" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price', $carDetail->price) }}" step="0.01" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('price') border-red-500 @enderror" required>
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>



            <!-- Is Available -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_available" id="is_available" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_available', $carDetail->is_available) ? 'checked' : '' }}>
                <label for="is_available" class="block text-base text-gray-700">Active Car Detail</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.car_details.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold shadow transition">Update Car Detail</button>
        </div>
    </form>
</div>
@endsection
