@extends('admin.layouts.app')

@section('title', 'Create Car')

@section('page-heading', 'Create New Car')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.cars.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
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

            <!-- Brand/Make -->
            <div>
                <label for="make_id" class="block text-sm font-semibold text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                <select name="make_id" id="make_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('make_id') border-red-500 @enderror" required>
                    <option value="">Select Brand</option>
                    @foreach ($makes as $make)
                        <option value="{{ $make->id }}" {{ old('make_id') == $make->id ? 'selected' : '' }}>{{ $make->name }}</option>
                    @endforeach
                </select>
                @error('make_id')
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
                    <option value="">Select Brand First</option>
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
                <select name="seat_number" id="seat_number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('seat_number') border-red-500 @enderror" required>
                    <option value="">Select Seats</option>
                    <option value="2" {{ old('seat_number') == 2 ? 'selected' : '' }}>2 Seats</option>
                    <option value="4" {{ old('seat_number') == 4 ? 'selected' : '' }}>4 Seats</option>
                    <option value="5" {{ old('seat_number') == 5 ? 'selected' : '' }}>5 Seats</option>
                    <option value="7" {{ old('seat_number') == 7 ? 'selected' : '' }}>7 Seats</option>
                    <option value="9" {{ old('seat_number') == 9 ? 'selected' : '' }}>9 Seats</option>
                </select>
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

            <!-- Main Image Upload -->
            <div class="col-span-2">
                <label for="main_image" class="block text-sm font-semibold text-gray-700 mb-1">Main Image <span class="text-red-500">*</span></label>
                <input type="file" name="main_image" id="main_image" accept="image/*" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('main_image') border-red-500 @enderror" required>
                @error('main_image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Images Upload -->
            <div class="col-span-2">
                <label for="additional_images" class="block text-sm font-semibold text-gray-700 mb-1">Additional Images</label>
                <input type="file" name="additional_images[]" id="additional_images" accept="image/*" multiple class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('additional_images.*') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">You can select multiple images</p>
                @error('additional_images.*')
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // When brand/make changes, load models
        const makeSelect = document.getElementById('make_id');
        const modelSelect = document.getElementById('model_id');

        // Initial state
        if (makeSelect.value) {
            loadModels(makeSelect.value);
        }

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

                    data.forEach(model => {
                        const selected = {{ old('model_id') ? 'model.id == ' . old('model_id') : 'false' }} ? 'selected' : '';
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
@endsection
