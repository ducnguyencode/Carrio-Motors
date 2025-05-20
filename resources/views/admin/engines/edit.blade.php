@extends('admin.layouts.app')

@section('title', 'Edit Engine')

@section('page-heading', 'Edit Engine')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.engines.update', $engine) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Engine Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Engine Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $engine->name) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Horsepower -->
            <div>
                <label for="horsepower" class="block text-sm font-semibold text-gray-700 mb-1">Horsepower</label>
                <input type="number" name="horsepower" id="horsepower" value="{{ old('horsepower', $engine->horsepower) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('horsepower') border-red-500 @enderror">
                @error('horsepower')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Level -->
            <div>
                <label for="level" class="block text-sm font-semibold text-gray-700 mb-1">Level</label>
                <input type="text" name="level" id="level" value="{{ old('level', $engine->level) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('level') border-red-500 @enderror">
                @error('level')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Max Speed -->
            <div>
                <label for="max_speed" class="block text-sm font-semibold text-gray-700 mb-1">Max Speed (km/h)</label>
                <input type="number" name="max_speed" id="max_speed" value="{{ old('max_speed', $engine->max_speed) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('max_speed') border-red-500 @enderror">
                @error('max_speed')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Drive Type -->
            <div>
                <label for="drive_type" class="block text-sm font-semibold text-gray-700 mb-1">Drive Type</label>
                <input type="text" name="drive_type" id="drive_type" value="{{ old('drive_type', $engine->drive_type) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('drive_type') border-red-500 @enderror">
                @error('drive_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Engine Type -->
            <div>
                <label for="engine_type" class="block text-sm font-semibold text-gray-700 mb-1">Engine Type</label>
                <div class="relative">
                    <select name="engine_type" id="engine_type" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('engine_type') border-red-500 @enderror">
                        <option value="">Select Engine Type</option>
                        <option value="Gasoline" {{ old('engine_type', $engine->engine_type) == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                        <option value="Diesel" {{ old('engine_type', $engine->engine_type) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Electric" {{ old('engine_type', $engine->engine_type) == 'Electric' ? 'selected' : '' }}>Electric</option>
                        <option value="Hybrid" {{ old('engine_type', $engine->engine_type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Plug-in Hybrid" {{ old('engine_type', $engine->engine_type) == 'Plug-in Hybrid' ? 'selected' : '' }}>Plug-in Hybrid</option>

                        @if($engine->engine_type && !in_array($engine->engine_type, ['Gasoline', 'Diesel', 'Electric', 'Hybrid', 'Plug-in Hybrid']))
                            <option value="{{ $engine->engine_type }}" selected>{{ $engine->engine_type }}</option>
                        @endif

                        <option value="custom" id="custom_engine_type_option">+ Add new engine type</option>
                    </select>
                    <input type="text" id="custom_engine_type" class="hidden w-full mt-2 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base" placeholder="Enter new engine type">
                </div>
                @error('engine_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center">
                <input type="checkbox" name="isActive" id="isActive" {{ old('isActive', $engine->isActive) ? 'checked' : '' }}
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="isActive" class="ml-2 block text-sm font-semibold text-gray-700">Active Status</label>
                @error('isActive')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.engines.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold shadow transition">Update Engine</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Custom engine_type handler
    document.addEventListener('DOMContentLoaded', function() {
        const engineTypeSelect = document.getElementById('engine_type');
        const customEngineTypeInput = document.getElementById('custom_engine_type');

        engineTypeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customEngineTypeInput.classList.remove('hidden');
                customEngineTypeInput.focus();
            } else {
                customEngineTypeInput.classList.add('hidden');
            }
        });

        customEngineTypeInput.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                // Create a new option and add it to the select
                const newOption = document.createElement('option');
                newOption.value = this.value;
                newOption.text = this.value;
                newOption.selected = true;

                // Insert before the "Add new" option
                const customOption = document.getElementById('custom_engine_type_option');
                engineTypeSelect.insertBefore(newOption, customOption);

                // Hide the custom input
                this.classList.add('hidden');
                this.value = '';
            }
        });
    });
</script>
@endpush
