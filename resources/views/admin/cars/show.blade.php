@extends('admin.layouts.app')

@section('title', 'Car Details')

@section('page-heading', 'Car Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Car Information</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.cars.edit', $car) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this car?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Car Name</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->name }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Brand</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->brand }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Manufactured Date</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->date_manufactured }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Seat Number</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->seat_number }}</p>
            </div>
        </div>
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Engine</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->engine->name }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Model</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->model->name }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Transmission</h3>
                <p class="mt-1 text-base text-gray-900">{{ ucfirst($car->transmission) }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <p class="mt-1">
                    @if($car->is_active)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-base text-gray-900">{{ $car->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">
            <i class="fas fa-arrow-left"></i> Back to Cars
        </a>
    </div>
</div>
@endsection