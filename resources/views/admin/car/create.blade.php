@extends('admin.layouts.app')

@section('title', 'Create Car')

@section('page-heading', 'Create New Car')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.cars.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Car Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Brand -->
            <div>
                <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                <input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('brand') border-red-500 @enderror" required>
                @error('brand')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date Manufactured -->
            <div>
                <label for="date_manufactured" class="block text-sm font-semibold text-gray-700 mb-1">Manufactured Date <span class="text-red-500">*</span></label>
                <input type="date" name="date_manufactured" id="date_manufactured" value="{{ old('date_manufactured') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('date_manufactured') border-red-500 @enderror" required>
                @error('date_manufactured')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Engine -->
            <div>
                <label for="engine_id" class="block text-sm font-semibold text-gray-700 mb-1">Engine <span class="text-red-500">*</span></label>
                <select name="engine_id" id="engine_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('engine_id') border-red-500 @enderror" required>
                    <option value="">Select Engine</option>
                    @foreach ($engines as $engine)
                        <option value="{{ $engine->id }}" {{ old('engine_id') == $engine->id ? 'selected' : '' }}>{{ $engine->name }}</option>
                    @endforeach
                </select>
                @error('engine_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Model -->
            <div>
                <label for="model_id" class="block text-sm font-semibold text-gray-700 mb-1">Model <span class="text-red-500">*</span></label>
                <select name="model_id" id="model_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('model_id') border-red-500 @enderror" required>
                    <option value="">Select Model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" {{ old('model_id') == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                    @endforeach
                </select>
                @error('model_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Seat Number -->
            <div>
                <label for="seat_number" class="block text-sm font-semibold text-gray-700 mb-1">Seat Number <span class="text-red-500">*</span></label>
                <input type="number" name="seat_number" id="seat_number" value="{{ old('seat_number') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('seat_number') border-red-500 @enderror" required>
                @error('seat_number')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Transmission -->
            <div>
                <label for="transmission" class="block text-sm font-semibold text-gray-700 mb-1">Transmission <span class="text-red-500">*</span></label>
                <select name="transmission" id="transmission" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('transmission') border-red-500 @enderror" required>
                    <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                </select>
                @error('transmission')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_active') ? 'checked' : '' }}>
                <label for="is_active" class="block text-base text-gray-700">Active Car</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.cars.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Create Car</button>
        </div>
    </form>
</div>
@endsection
