@extends('admin.layouts.app')

@section('title', 'Activity Log Details')

@section('page-heading', 'Activity Log Details')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-4">
        <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Back to logs
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Date & Time</p>
                <p class="mt-1 text-sm text-gray-900">{{ $activityLog->created_at->format('Y-m-d H:i:s') }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">User</p>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $activityLog->user_name ?? 'System' }}
                    @if($activityLog->user_role)
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800">
                            {{ ucfirst($activityLog->user_role) }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">IP Address</p>
                <p class="mt-1 text-sm text-gray-900">{{ $activityLog->ip_address ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Action</p>
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
                <p class="text-sm font-medium text-gray-500">Module</p>
                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($activityLog->module) }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Reference ID</p>
                <p class="mt-1 text-sm text-gray-900">{{ $activityLog->reference_id ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Details</h3>

            @if($activityLog->details)
                <pre class="bg-gray-100 p-4 rounded overflow-auto text-sm max-h-96">{{ json_encode($activityLog->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @else
                <p class="text-sm text-gray-500">No additional details available</p>
            @endif

            <div class="mt-4">
                <p class="text-sm font-medium text-gray-500">User Agent</p>
                <p class="mt-1 text-sm text-gray-700 break-words">{{ $activityLog->user_agent ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
