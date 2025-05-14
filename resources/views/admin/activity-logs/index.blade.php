@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('page-heading', 'Activity Logs')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Filter Logs</h2>
        <form action="{{ route('activity-logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Users</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="action" class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                <select name="action" id="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="module" class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                <select name="module" id="module" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>{{ ucfirst($module) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 lg:col-span-4 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
                <a href="{{ route('activity-logs.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Reset
                </a>
            </div>
        </form>
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
                            <a href="{{ route('activity-logs.show', $log) }}" class="text-indigo-600 hover:text-indigo-900">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No activity logs found</td>
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
