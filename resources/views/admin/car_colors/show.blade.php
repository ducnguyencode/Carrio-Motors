@extends('admin.layouts.app')

@section('title', 'Car Color Details')

@section('page-heading', 'Car Color Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Car Color Information</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.car_colors.edit', $carColor) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.car_colors.destroy', $carColor) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this color?')">
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
                <h3 class="text-sm font-medium text-gray-500">Color Name</h3>
                <p class="mt-1 text-base text-gray-900">{{ $carColor->name }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <p class="mt-1">
                    @if($carColor->is_active)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-base text-gray-900">{{ $carColor->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($carColor->updated_at)
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Updated At</h3>
                <p class="mt-1 text-base text-gray-900">{{ $carColor->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @endif
        </div>
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Hex Code</h3>
                <p class="mt-1 text-base text-gray-900 font-mono">{{ $carColor->hex_code }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Color Preview</h3>
                <div class="mt-2 flex items-center">
                    <div class="w-16 h-16 rounded-lg border border-gray-300" style="background-color: {{ $carColor->hex_code }}"></div>
                    <div class="ml-4 p-2 bg-gray-800 text-white rounded">
                        <span class="font-mono text-sm">{{ $carColor->hex_code }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Associated Cars</h3>
                <div class="mt-2">
                    @if($carColor->carDetails && $carColor->carDetails->count() > 0)
                        <ul class="list-disc list-inside">
                            @foreach($carColor->carDetails as $detail)
                                <li class="text-gray-700">
                                    <a href="{{ route('admin.cars.show', $detail->car_id) }}" class="text-blue-600 hover:underline">
                                        {{ $detail->car->name ?? 'Unknown Car' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">No cars are using this color.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.car_colors.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">
            <i class="fas fa-arrow-left"></i> Back to Car Colors
        </a>
    </div>
</div>
@endsection
