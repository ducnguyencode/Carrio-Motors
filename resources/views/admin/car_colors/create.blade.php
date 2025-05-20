@extends('admin.layouts.app')

@section('title', 'Create Car Color')

@section('page-heading', 'Create New Car Color')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.car_colors.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Color Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                    Color Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none form-input @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hex Code with Color Picker -->
            <div>
                <label for="hex_code" class="block text-sm font-semibold text-gray-700 mb-1">
                    Color <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center color-picker-wrapper">
                    <input type="color" id="color_picker"
                           value="{{ old('hex_code', '#FF0000') }}"
                           class="color-picker border-0 cursor-pointer"
                           onchange="updateColorInfo(this.value)">
                    <input type="text" name="hex_code" id="hex_code"
                           value="{{ old('hex_code', '#FF0000') }}"
                           class="w-full px-4 py-3 h-12 rounded-r-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none form-input uppercase @error('hex_code') border-red-500 @enderror"
                           oninput="updateColorInfo(this.value)"
                           required>
                </div>
                @error('hex_code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color Preview -->
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Color Preview</label>
                <div class="flex items-center space-x-4">
                    <div id="color_preview" class="h-24 w-24 border border-gray-300 rounded-lg shadow-sm transition-all" style="background-color: {{ old('hex_code', '#FF0000') }}"></div>
                    <div class="text-gray-600">
                        <p class="text-base font-medium">This is how the color will appear on the website.</p>
                        <p class="text-sm text-gray-500 mt-1">Make sure it has good contrast with text.</p>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-span-2 flex items-center mt-2">
                <input type="checkbox" name="is_active" id="is_active"
                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                       checked>
                <label for="is_active" class="ml-2 text-gray-700">Active</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.car_colors.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition-all">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition-all">Create Car Color</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateColorInfo(color) {
        // Only update the color preview if a valid color is provided
        if (/^#([0-9A-F]{3}){1,2}$/i.test(color)) {
            document.getElementById('color_preview').style.backgroundColor = color;

            // If change came from the color picker, update the text field
            if (event && event.target.id === 'color_picker') {
                document.getElementById('hex_code').value = color.toUpperCase();
            }

            // If change came from the text field, update the color picker
            if (event && event.target.id === 'hex_code') {
                document.getElementById('color_picker').value = color;
            }
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const hexInput = document.getElementById('hex_code');
        const colorPicker = document.getElementById('color_picker');

        // Ensure hex code is uppercase
        if(hexInput.value) {
            hexInput.value = hexInput.value.toUpperCase();
            colorPicker.value = hexInput.value;
            document.getElementById('color_preview').style.backgroundColor = hexInput.value;
        }
    });
</script>
@endpush
@endsection
