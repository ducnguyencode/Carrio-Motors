@extends('admin.layouts.app')

@section('title', 'Create Engine')

@section('page-heading', 'Create New Engine')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.engines.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Engine Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Engine Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Horsepower -->
            <div>
                <label for="horsepower" class="block text-sm font-semibold text-gray-700 mb-1">Horsepower <span class="text-red-500">*</span></label>
                <input type="number" name="horsepower" id="horsepower" value="{{ old('horsepower') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('horsepower') border-red-500 @enderror"
                    required>
                @error('horsepower')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Max Speed -->
            <div>
                <label for="max_speed" class="block text-sm font-semibold text-gray-700 mb-1">Max Speed (km/h) <span class="text-red-500">*</span></label>
                <input type="number" name="max_speed" id="max_speed" value="{{ old('max_speed') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('max_speed') border-red-500 @enderror"
                    required>
                @error('max_speed')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Drive Type -->
            <div>
                <label for="drive_type" class="block text-sm font-semibold text-gray-700 mb-1">Drive Type <span class="text-red-500">*</span></label>
                <input type="text" name="drive_type" id="drive_type" value="{{ old('drive_type') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('drive_type') border-red-500 @enderror"
                    required>
                @error('drive_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Engine Type -->
            <div>
                <label for="engine_type" class="block text-sm font-semibold text-gray-700 mb-1">Engine Type <span class="text-red-500">*</span></label>
                <input type="text" name="engine_type" id="engine_type" value="{{ old('engine_type') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('engine_type') border-red-500 @enderror"
                    required>
                @error('engine_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.engines.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Create Engine</button>
        </div>
    </form>
</div>
@endsection