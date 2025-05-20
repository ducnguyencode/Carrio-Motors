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
                <label for="make_id" class="absolute left-4 top-2 text-gray-400 pointer-events-none transition-all duration-200"> <i class="fas fa-industry mr-1"></i> Brand *</label>
                <select name="make_id" id="make_id" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('make_id') border-red-500 @enderror" required>
                    <option value="">Select Brand</option>
                    @foreach ($makes as $make)
                        <option value="{{ $make->id }}" {{ old('make_id', $car->model->make_id) == $make->id ? 'selected' : '' }}>{{ $make->name }}</option>
                    @endforeach
                </select>
                @error('make_id')
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
                <select name="seat_number" id="seat_number" class="w-full pt-7 pb-2 px-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base bg-gray-50 shadow-sm @error('seat_number') border-red-500 @enderror" required>
                    <option value="">Select Seats</option>
                    <option value="2" {{ old('seat_number', $car->seat_number) == 2 ? 'selected' : '' }}>2 Seats</option>
                    <option value="4" {{ old('seat_number', $car->seat_number) == 4 ? 'selected' : '' }}>4 Seats</option>
                    <option value="5" {{ old('seat_number', $car->seat_number) == 5 ? 'selected' : '' }}>5 Seats</option>
                    <option value="7" {{ old('seat_number', $car->seat_number) == 7 ? 'selected' : '' }}>7 Seats</option>
                    <option value="9" {{ old('seat_number', $car->seat_number) == 9 ? 'selected' : '' }}>9 Seats</option>
                </select>
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
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_active', $car->isActive) ? 'checked' : '' }}>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // When brand/make changes, load models
        const makeSelect = document.getElementById('make_id');
        const modelSelect = document.getElementById('model_id');

        // Initial state - already loaded with the car's models

        // On change event
        makeSelect.addEventListener('change', function() {
            if (this.value) {
                loadModels(this.value);
            } else {
                // Clear models dropdown
                modelSelect.innerHTML = '<option value="">Select Brand First</option>';
            }
        });

        // Function to load models via AJAX
        function loadModels(makeId) {
            // Show loading state
            modelSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`{{ route('admin.get-models-by-make') }}?make_id=${makeId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear and populate the models dropdown
                    modelSelect.innerHTML = '<option value="">Select Model</option>';

                    if (data.length === 0) {
                        modelSelect.innerHTML = '<option value="">No models available</option>';
                        return;
                    }

                    const currentModelId = {{ old('model_id', $car->model_id) }};

                    data.forEach(model => {
                        const selected = model.id == currentModelId ? 'selected' : '';
                        modelSelect.innerHTML += `<option value="${model.id}" ${selected}>${model.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading models:', error);
                    modelSelect.innerHTML = '<option value="">Error loading models</option>';
                });
        }
    });
</script>
@endpush
