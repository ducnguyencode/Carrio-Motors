@extends('admin.layouts.app')

@section('title', 'Activity Log Details')

@section('page-heading', 'Activity Log Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-4">
        <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-4 py-2 rounded-full border border-blue-500 text-blue-500 bg-white hover:bg-blue-50 transition-all text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Back to Logs
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                Basic Information
            </h3>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600">Date & Time</p>
                <p class="mt-1 text-base text-gray-900">{{ $activityLog->created_at->format('Y-m-d H:i:s') }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600">User</p>
                <p class="mt-1 text-base text-gray-900">
                    {{ $activityLog->user_name ?? 'System' }}
                    @if($activityLog->user_role)
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($activityLog->user_role) }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600">IP Address</p>
                <p class="mt-1 text-base text-gray-900">{{ $activityLog->ip_address ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600">Action</p>
                <p class="mt-1">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $activityLog->action == 'create' ? 'bg-green-100 text-green-800' :
                           ($activityLog->action == 'update' ? 'bg-blue-100 text-blue-800' :
                              ($activityLog->action == 'delete' ? 'bg-red-100 text-red-800' :
                                 ($activityLog->action == 'login' ? 'bg-purple-100 text-purple-800' :
                                    ($activityLog->action == 'logout' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')))) }}">
                        {{ ucfirst($activityLog->action) }}
                    </span>
                </p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600">Module</p>
                <p class="mt-1 text-base text-gray-900">{{ ucfirst($activityLog->module) }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-600">Reference ID</p>
                <p class="mt-1 text-base text-gray-900">{{ $activityLog->reference_id ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd" />
                </svg>
                Details
            </h3>

            @if($activityLog->details)
                <pre class="bg-gray-100 p-4 rounded-lg overflow-auto text-sm max-h-96 border border-gray-200">{{ json_encode($activityLog->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @else
                <div class="p-4 text-center bg-gray-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500">No additional details available</p>
                </div>
            @endif

            <div class="mt-4">
                <p class="text-sm font-semibold text-gray-600">User Agent</p>
                <p class="mt-1 text-sm text-gray-700 break-words bg-gray-100 p-3 rounded-lg">{{ $activityLog->user_agent ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
