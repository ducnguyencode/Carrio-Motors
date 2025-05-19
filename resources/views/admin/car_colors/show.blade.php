@extends('admin.layouts.app')

@section('title', 'Car Color Details')

@section('page-heading', 'Car Color Information')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Color Name</h3>
            <p class="mt-1 text-base text-gray-900">{{ $carColor->name }}</p>

            <h3 class="text-sm font-medium text-gray-500">Hex Code</h3>
            <p class="mt-1 text-base text-gray-900 px-4 py-2 rounded-md" style="background-color: {{ $carColor->hex_code }}">
                {{ $carColor->hex_code }}
            </p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Status</h3>
            <p class="mt-1">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $carColor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $carColor->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('car_colors.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">Back to Colors</a>
    </div>
</div>
@endsection