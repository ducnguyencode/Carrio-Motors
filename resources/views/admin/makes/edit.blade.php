@extends('admin.layouts.app')

@section('title', 'Edit Make')

@section('page-heading', 'Edit Make')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <form action="{{ route('admin.makes.update', $make) }}" method="POST" class="space-y-6">
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

        <div class="flex justify-end gap-2 mt-8">
            <a href="{{ route('admin.makes.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold shadow transition">Update Make</button>
        </div>
    </form>
</div>
@endsection