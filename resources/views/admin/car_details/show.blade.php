@extends('admin.layouts.app')

@section('title', 'Car Detail')

@section('page-heading', 'Car Detail Information')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Car Detail</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.car_details.edit', $carDetail) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.car_details.destroy', $carDetail) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this car detail?')">
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
                <p class="mt-1 text-base text-gray-900">{{ $carDetail->car->name }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Color</h3>
                <p class="mt-1 text-base text-gray-900">{{ $carDetail->carColor->name }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Quantity</h3>
                <p class="mt-1 text-base text-gray-900">{{ $carDetail->quantity }}</p>
            </div>
        </div>
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Price</h3>
                <p class="mt-1 text-base text-gray-900">${{ number_format($carDetail->price, 2) }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <p class="mt-1">
                    @if($carDetail->is_available)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-base text-gray-900">{{ $carDetail->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Images Section -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Images</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Main Image -->
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Main Image</h4>
                @if($carDetail->main_image)
                    <img src="{{ asset($carDetail->main_image) }}" alt="Main car image" class="w-full max-w-sm h-auto rounded-lg border border-gray-200">
                @else
                    <p class="text-gray-500 italic">No main image available</p>
                @endif
            </div>

            <!-- Additional Images -->
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Additional Images</h4>
                @if($carDetail->additional_images)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach(json_decode($carDetail->additional_images) ?? [] as $image)
                            <a href="{{ asset($image) }}" target="_blank">
                                <img src="{{ asset($image) }}" alt="Additional car image" class="w-full h-32 object-cover rounded-lg border border-gray-200 hover:opacity-90 transition">
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No additional images available</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.car_details.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">
            <i class="fas fa-arrow-left"></i> Back to Car Details
        </a>
    </div>
</div>
@endsection
