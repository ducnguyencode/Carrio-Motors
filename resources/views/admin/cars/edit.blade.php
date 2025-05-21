@extends('admin.layouts.app')

@section('title', 'Edit Car')

@section('page-heading', 'Edit Car')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-10 max-w-4xl mx-auto mt-6">
    <form action="{{ route('admin.cars.update', $car) }}" method="POST" class="space-y-8" enctype="multipart/form-data">
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
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_active', $car->isActive) ? 'checked' : '' }}>
                <label for="is_active" class="block text-base text-gray-700">Active Car</label>
            </div>
        </div>

        <!-- Main Image Upload -->
        <div class="mt-8">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Main Image</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="mb-3">
                        @if($car->main_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $car->main_image) }}" alt="{{ $car->name }}" class="w-full h-auto max-h-64 object-cover rounded-lg shadow-md">
                            </div>
                        @else
                            <div class="p-4 bg-gray-100 rounded-lg text-center text-gray-500">
                                <p>No image available</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-center w-full">
                        <label for="main_image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 2MB)</p>
                            </div>
                            <input id="main_image" name="main_image" type="file" class="hidden" accept="image/*" onchange="previewMainImage(this)" />
                        </label>
                    </div>
                    <div id="main_image_preview" class="mt-3 hidden">
                        <img src="" alt="Preview" class="w-full h-auto max-h-48 object-cover rounded-lg shadow-sm">
                    </div>
                </div>
            </div>
            @error('main_image')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Additional Images Upload -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Images</label>

            @if($car->additional_images)
                <div class="mb-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(json_decode($car->additional_images) ?? [] as $index => $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image) }}" alt="Additional Image {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg shadow-sm">
                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                    <div class="flex space-x-2">
                                        <a href="{{ asset('storage/' . $image) }}" target="_blank" class="p-2 bg-blue-500 text-white rounded-full">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <label class="p-2 bg-red-500 text-white rounded-full cursor-pointer">
                                            <i class="fas fa-trash"></i>
                                            <input type="checkbox" name="remove_additional_images[]" value="{{ $index }}" class="hidden">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Hover over images to see options. Check to remove during update.</p>
                </div>
            @endif

            <div class="flex items-center justify-center w-full">
                <label for="additional_images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> multiple images</p>
                        <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 2MB each)</p>
                    </div>
                    <input id="additional_images" name="additional_images[]" type="file" class="hidden" accept="image/*" multiple onchange="previewAdditionalImages(this)" />
                </label>
            </div>
            <div id="additional_images_preview" class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                <!-- Preview images will be inserted here by JavaScript -->
            </div>
            @error('additional_images.*')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mt-6">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('description') border-red-500 @enderror">{{ old('description', $car->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
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

        // Handle checkbox toggling for remove_additional_images
        document.querySelectorAll('input[name="remove_additional_images[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const parent = this.closest('.relative');
                if (this.checked) {
                    parent.classList.add('opacity-50');
                } else {
                    parent.classList.remove('opacity-50');
                }
            });
        });
    });

    function previewMainImage(input) {
        const preview = document.getElementById('main_image_preview');
        const previewImg = preview.querySelector('img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            previewImg.src = '';
        }
    }

    function previewAdditionalImages(input) {
        const preview = document.getElementById('additional_images_preview');
        preview.innerHTML = '';

        if (input.files && input.files.length > 0) {
            preview.classList.remove('hidden');

            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();
                const file = input.files[i];

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${i + 1}" class="w-full h-32 object-cover rounded-lg shadow-sm">
                        <div class="absolute top-2 right-2 bg-gray-800 bg-opacity-50 rounded-full p-1 text-xs text-white">
                            ${file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name}
                        </div>
                    `;
                    preview.appendChild(div);
                };

                reader.readAsDataURL(file);
            }
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
@endpush
