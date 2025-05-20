@extends('admin.layouts.app')

@section('title', 'Engine Details')

@section('page-heading', 'Engine Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Engine Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Engine Name:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $engine->name }}</p>
        </div>

        <!-- Horsepower -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Horsepower:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $engine->horsepower ?: 'N/A' }}</p>
        </div>

        <!-- Level -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Level:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $engine->level ?: 'N/A' }}</p>
        </div>

        <!-- Max Speed -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Max Speed:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $engine->max_speed ? $engine->max_speed . ' km/h' : 'N/A' }}</p>
        </div>

        <!-- Drive Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Drive Type:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $engine->drive_type ?: 'N/A' }}</p>
        </div>

        <!-- Engine Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Engine Type:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">{{ $engine->engine_type ?: 'N/A' }}</p>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Status:</label>
            <p class="px-4 py-3 bg-gray-100 rounded-lg">
                @if($engine->isActive)
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                @else
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                @endif
            </p>
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-8">
        <a href="{{ route('admin.engines.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Back</a>
        <a href="{{ route('admin.engines.edit', $engine) }}" class="px-6 py-2 rounded-lg bg-yellow-600 text-white hover:bg-yellow-700 font-semibold shadow transition">Edit Engine</a>
    </div>
</div>
@endsection
