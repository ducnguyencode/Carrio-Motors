@extends('admin.layouts.app')

@section('title', 'Create Model')

@section('page-heading', 'Create New Model')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.models.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Model Name -->
            <div class="md:col-span-1">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                    Model Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Make -->
            <div class="md:col-span-1">
                <label for="make_id" class="block text-sm font-semibold text-gray-700 mb-1">
                    Make <span class="text-red-500">*</span>
                </label>
                <select name="make_id" id="make_id"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 @error('make_id') border-red-500 @enderror"
                        required>
                    <option value="">Select Make</option>
                    @foreach ($makes as $make)
                        <option value="{{ $make->id }}" {{ old('make_id') == $make->id ? 'selected' : '' }}>
                            {{ $make->name }}
                        </option>
                    @endforeach
                </select>
                @error('make_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Year -->
            <div class="md:col-span-1">
                <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">
                    Year
                </label>
                <input type="number" name="year" id="year"
                       value="{{ old('year') }}"
                       placeholder="YYYY"
                       min="1886" max="{{ date('Y') + 1 }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('year') border-red-500 @enderror">
                @error('year')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="md:col-span-2">
                <div class="flex items-center">
                <input type="checkbox" name="isActive" id="isActive"
                           class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           {{ old('isActive', true) ? 'checked' : '' }}>
                <label for="isActive" class="ml-2 text-gray-700">Active Model</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.models.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Create Model</button>
        </div>
    </form>
</div>
@endsection
