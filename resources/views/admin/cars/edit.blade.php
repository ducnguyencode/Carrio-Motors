@extends('admin.layouts.app')

@section('title', 'Edit Car')

@section('page-heading', 'Edit Car')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-10 max-w-2xl mx-auto mt-6">
    <form action="{{ route('admin.cars.update', $car) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Car Name -->
            <div class="relative">
                <label for="name" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-car mr-1"></i> Car Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $car->name) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('name') border-red-500 @enderror" required autocomplete="off">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Brand -->
            <div class="relative">
                <label for="brand" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-industry mr-1"></i> Brand *</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand', $car->brand) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('brand') border-red-500 @enderror" required autocomplete="off">
                @error('brand')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date Manufactured -->
            <div class="relative">
                <label for="date_manufactured" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-calendar-alt mr-1"></i> Manufactured Date *</label>
                <input type="date" name="date_manufactured" id="date_manufactured" value="{{ old('date_manufactured', $car->date_manufactured) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('date_manufactured') border-red-500 @enderror" required>
                @error('date_manufactured')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Engine -->
            <div class="relative">
                <label for="engine_id" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-cogs mr-1"></i> Engine *</label>
                <select name="engine_id" id="engine_id" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('engine_id') border-red-500 @enderror" required>
                    <option value="">Select Engine</option>
                    @foreach ($engines as $engine)
                        <option value="{{ $engine->id }}" {{ old('engine_id', $car->engine_id) == $engine->id ? 'selected' : '' }}>{{ $engine->name }}</option>
                    @endforeach
                </select>
                @error('engine_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Model -->
            <div class="relative">
                <label for="model_id" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-car-side mr-1"></i> Model *</label>
                <select name="model_id" id="model_id" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('model_id') border-red-500 @enderror" required>
                    <option value="">Select Model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" {{ old('model_id', $car->model_id) == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                    @endforeach
                </select>
                @error('model_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Seat Number -->
            <div class="relative">
                <label for="seat_number" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-chair mr-1"></i> Seat Number *</label>
                <input type="number" name="seat_number" id="seat_number" value="{{ old('seat_number', $car->seat_number) }}" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('seat_number') border-red-500 @enderror" required>
                @error('seat_number')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Transmission -->
            <div class="relative">
                <label for="transmission" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-exchange-alt mr-1"></i> Transmission *</label>
                <select name="transmission" id="transmission" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('transmission') border-red-500 @enderror" required>
                    <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                    <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                </select>
                @error('transmission')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_active', $car->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="block text-base text-gray-700">Active Car</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.cars.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 text-white hover:from-blue-600 hover:to-blue-800 font-semibold shadow transition">Update Car</button>
        </div>
    </form>
</div>
@endsection