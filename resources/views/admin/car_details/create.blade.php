@extends('admin.layouts.app')

@section('title', 'Create Car Detail')

@section('page-heading', 'Create New Car Detail')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.car_details.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car -->
            <div>
                <label for="car_id" class="block text-sm font-semibold text-gray-700 mb-1">Car <span class="text-red-500">*</span></label>
                <select id="car_id" name="car_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('car_id') border-red-500 @enderror" required>
                    <option value="">Select a car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->brand }})
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color -->
            <div>
                <label for="color_id" class="block text-sm font-semibold text-gray-700 mb-1">Color <span class="text-red-500">*</span></label>
                <select id="color_id" name="color_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('color_id') border-red-500 @enderror" required>
                    <option value="">Select a color</option>
                    @foreach($carcolors as $color)
                        <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                            {{ $color->color_name }}
                        </option>
                    @endforeach
                </select>
                @error('color_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                <input type="number" id="quantity" name="quantity" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('quantity') border-red-500 @enderror" value="{{ old('quantity') }}" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                <input type="number" id="price" name="price" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('price') border-red-500 @enderror" value="{{ old('price') }}" required>
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_active') ? 'checked' : '' }}>
                <label for="is_active" class="block text-base text-gray-700">Active Car Detail</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.car_details.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Save Car Detail</button>
        </div>
    </form>
</div>
@endsection