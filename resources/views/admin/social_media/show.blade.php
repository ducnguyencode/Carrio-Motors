@extends('admin.layouts.app')

@section('title', 'View Social Media Link')

@section('page-heading', 'Social Media Link Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <a href="{{ route('admin.social-media.index') }}" class="inline-flex items-center text-blue-600 hover:underline">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Social Media Links
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <i class="{{ $social_medium->icon_class }} mr-2 text-gray-700"></i>
                {{ $social_medium->platform_name }}
            </h2>

            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">URL</h3>
                    <a href="{{ $social_medium->url }}" target="_blank" class="text-blue-600 hover:underline block mt-1">
                        {{ $social_medium->url }}
                        <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Icon Class</h3>
                    <p class="mt-1 text-gray-900">{{ $social_medium->icon_class }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Display Order</h3>
                    <p class="mt-1 text-gray-900">{{ $social_medium->display_order }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                    <span class="px-2 py-1 mt-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $social_medium->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $social_medium->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Meta Information</h2>

            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                    <p class="mt-1 text-gray-900">{{ $social_medium->created_at->format('F j, Y g:i A') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Last Updated</h3>
                    <p class="mt-1 text-gray-900">{{ $social_medium->updated_at->format('F j, Y g:i A') }}</p>
                </div>

                <div class="pt-4 border-t border-gray-200 mt-6">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.social-media.edit', ['social_medium' => $social_medium->id]) }}" class="bg-yellow-100 text-yellow-600 hover:bg-yellow-200 px-4 py-2 rounded-md text-sm font-medium inline-flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <form action="{{ route('admin.social-media.toggle-active', $social_medium->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-100 text-blue-600 hover:bg-blue-200 px-4 py-2 rounded-md text-sm font-medium inline-flex items-center">
                                <i class="fas fa-toggle-on mr-2"></i> {{ $social_medium->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.social-media.destroy', ['social_medium' => $social_medium->id]) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 rounded-md text-sm font-medium inline-flex items-center">
                                <i class="fas fa-trash-alt mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Confirm delete
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this social media link?')) {
                this.submit();
            }
        });
    });
</script>
@endpush
