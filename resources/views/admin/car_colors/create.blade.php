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
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hex Code -->
            <div>
                <label for="hex_code" class="block text-sm font-semibold text-gray-700 mb-1">
                    Hex Code <span class="text-red-500">*</span>
                </label>
                <input type="text" name="hex_code" id="hex_code"
                       value="{{ old('hex_code') }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('hex_code') border-red-500 @enderror"
                       required>
                @error('hex_code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_active" id="is_active"
                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ old('is_active') ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-gray-700">Active</label>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.car_colors.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow transition">Create Car Color</button>
        </div>
    </form>
</div>
@endsection