@extends('admin.layouts.app')

@section('title', 'Create Car Detail')

@section('page-heading', 'Create New Car Detail')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.car_details.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Car -->
            <div>
                <label for="car_id" class="block text-sm font-semibold text-gray-700 mb-1">Car <span class="text-red-500">*</span></label>
                <select name="car_id" id="car_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('car_id') border-red-500 @enderror" required>
                    <option value="">Select a car</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
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
                    @foreach($carcolors as $color)
                        <option value="{{ $color->id }}" {{ old('car_color_id') == $color->id ? 'selected' : '' }} style="background-color: {{ $color->hex_code ?? '#fff' }}">
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
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('quantity') border-red-500 @enderror" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('price') border-red-500 @enderror" required>
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Main Image -->
            <div class="md:col-span-2">
                <label for="main_image" class="block text-sm font-semibold text-gray-700 mb-1">Main Image</label>
                <input type="file" name="main_image" id="main_image" accept="image/*" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('main_image') border-red-500 @enderror">
                <div id="main-image-preview" class="mt-2"></div>
                @error('main_image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Images -->
            <div class="md:col-span-2">
                <label for="additional_images" class="block text-sm font-semibold text-gray-700 mb-1">Additional Images</label>
                <div class="flex items-center space-x-2">
                    <input type="file" name="additional_images[]" id="additional_images" accept="image/*" multiple class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('additional_images') border-red-500 @enderror">
                    <button type="button" id="clear-additional-images" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Clear</button>
                </div>
                <p class="mt-1 text-sm text-blue-600 font-medium">You can select multiple images at once. Just hold Ctrl (Windows) or Command (Mac) and select multiple files.</p>
                <div id="additional-images-preview" class="mt-2 grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
                <p class="mt-1 text-xs text-gray-500"><span id="selected-count">0</span> images selected</p>
                @error('additional_images')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Available -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_available" id="is_available" value="1" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2" {{ old('is_available') ? 'checked' : '' }}>
                <label for="is_available" class="block text-base text-gray-700">Active Car Detail</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.car_details.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Create Car Detail</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Main image preview
    const mainImageInput = document.getElementById('main_image');
    const mainImagePreview = document.getElementById('main-image-preview');

    mainImageInput.addEventListener('change', function() {
        mainImagePreview.innerHTML = '';
        if (this.files && this.files[0]) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(this.files[0]);
            img.className = 'w-32 h-32 object-cover rounded-md border border-gray-300 mt-2';
            img.onload = function() {
                URL.revokeObjectURL(this.src);
            }
            mainImagePreview.appendChild(img);
        }
    });

    // Additional images preview
    const additionalImagesInput = document.getElementById('additional_images');
    const additionalImagesPreview = document.getElementById('additional-images-preview');
    const selectedCount = document.getElementById('selected-count');
    const clearBtn = document.getElementById('clear-additional-images');

    additionalImagesInput.addEventListener('change', function() {
        additionalImagesPreview.innerHTML = '';
        selectedCount.textContent = this.files.length;

        if (this.files && this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(this.files[i]);
                img.className = 'w-full h-24 object-cover rounded-md border border-gray-300';
                img.onload = function() {
                    URL.revokeObjectURL(this.src);
                }

                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative';
                imgContainer.appendChild(img);

                // Show file name on hover
                imgContainer.title = this.files[i].name;

                additionalImagesPreview.appendChild(imgContainer);
            }
        }
    });

    // Clear button functionality
    clearBtn.addEventListener('click', function() {
        additionalImagesInput.value = '';
        additionalImagesPreview.innerHTML = '';
        selectedCount.textContent = '0';
    });
});
</script>
@endpush
@endsection
