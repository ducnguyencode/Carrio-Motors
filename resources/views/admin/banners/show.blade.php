@extends('admin.layouts.app')

@section('title', 'Banner Details')

@section('page-heading', 'Banner Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Banner Information</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.banners.edit', $banner) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this banner?')">
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
                <h3 class="text-sm font-medium text-gray-500">Title</h3>
                <p class="mt-1 text-base text-gray-900">{{ $banner->title ?: 'No title' }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Content</h3>
                <p class="mt-1 text-base text-gray-900">{{ $banner->main_content ?: 'No content' }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Position</h3>
                <p class="mt-1 text-base text-gray-900">{{ $banner->position ?: 'Not set' }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Click URL</h3>
                @if($banner->click_url)
                    <a href="{{ $banner->click_url }}" target="_blank" class="mt-1 text-blue-600 hover:underline">{{ $banner->click_url }}</a>
                @else
                    <p class="mt-1 text-gray-500 italic">No URL set</p>
                @endif
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Linked Car</h3>
                @if($banner->car)
                    <a href="{{ route('admin.cars.show', $banner->car_id) }}" class="mt-1 text-blue-600 hover:underline">{{ $banner->car->name }}</a>
                @else
                    <p class="mt-1 text-gray-500 italic">No car linked</p>
                @endif
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <p class="mt-1">
                    @if($banner->is_active)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                <p class="mt-1 text-base text-gray-900">{{ $banner->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($banner->updated_at)
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Updated At</h3>
                <p class="mt-1 text-base text-gray-900">{{ $banner->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @endif
        </div>

        <div>
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Video</h3>
                @if($banner->video_url)
                    <div class="mt-2 rounded-lg overflow-hidden border border-gray-200 max-w-lg">
                        <video controls class="w-full h-auto">
                            <source src="{{ Storage::url($banner->video_url) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Video URL: {{ Storage::url($banner->video_url) }}
                    </p>
                @else
                    <p class="mt-1 text-gray-500 italic">No video uploaded</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">
            <i class="fas fa-arrow-left"></i> Back to Banners
        </a>
    </div>
</div>
@endsection
