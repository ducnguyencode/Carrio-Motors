@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('page-heading', 'Activity Logs')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Activity History</h2>
        <div class="flex items-center gap-2">
            <form action="{{ route('activity-logs.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <!-- User Filter -->
                <select name="user_id" class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                    <option value="">All Users</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>

                <!-- Action Filter -->
                <select name="action" class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>

                <!-- Module Filter -->
                <select name="module" class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                    <option value="">All Modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>{{ ucfirst($module) }}</option>
                    @endforeach
                </select>

                <!-- Date From -->
                <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From Date"
                       class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">

                <!-- Date To -->
                <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="To Date"
                       class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">

                <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-full border border-blue-500 text-blue-500 bg-white hover:bg-blue-50 transition-all text-sm font-medium">
                    <i class="fas fa-filter"></i> Filter
                </button>

                @if(request('user_id') || request('action') || request('module') || request('date_from') || request('date_to'))
                <a href="{{ route('activity-logs.index') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $log->user_name ?? 'System' }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($log->user_role ?? 'N/A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $log->action == 'create' ? 'bg-green-100 text-green-800' :
                                   ($log->action == 'update' ? 'bg-blue-100 text-blue-800' :
                                      ($log->action == 'delete' ? 'bg-red-100 text-red-800' :
                                         ($log->action == 'login' ? 'bg-purple-100 text-purple-800' :
                                            ($log->action == 'logout' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')))) }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ucfirst($log->module) }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('activity-logs.show', $log) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No activity logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->withQueryString()->links() }}
    </div>
</div>
@endsection
