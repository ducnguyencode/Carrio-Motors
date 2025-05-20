@extends('admin.layouts.app')

@section('title', 'Edit Make')

@section('page-heading', 'Edit Make')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.makes.update', $make) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Make Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $make->name) }}"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-base @error('name') border-red-500 @enderror"
                required>
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description', $make->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo" class="block text-sm font-semibold text-gray-700 mb-1">Logo</label>
            <div class="mt-1 flex items-center">
                @if($make->logo)
                    <div class="relative">
                        <img src="{{ $make->logo_url }}" alt="{{ $make->name }}" class="h-20 w-auto rounded">
                    </div>
                @else
                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                @endif
                <input type="file" name="logo" id="logo"
                    class="ml-5 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            </div>
            <p class="mt-1 text-sm text-gray-500">
                Upload a new logo image (JPEG, PNG, GIF). Maximum size 2MB. Leave blank to keep the current logo.
            </p>
            @error('logo')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="isActive" id="isActive"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                {{ old('isActive', $make->isActive) ? 'checked' : '' }}>
            <label for="isActive" class="ml-2 block text-sm text-gray-700">
                Active
            </label>
        </div>

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.makes.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold shadow transition">Update Make</button>
        </div>
    </form>
</div>
@endsection
