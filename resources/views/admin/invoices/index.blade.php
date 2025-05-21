@extends('admin.layouts.app')

@section('title', 'Invoices')

@section('page-heading', 'Invoices')

@php
    // Set flag to prevent duplicate flash messages from layout
    $hideFlashMessages = true;
@endphp

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-wrap justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">All Invoices</h2>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.invoices.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice..." class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                <select name="status" class="border border-gray-300 rounded-full px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm">
                    <option value="">All Status</option>
                    @foreach(\App\Models\Invoice::getStatuses() as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded-full border border-blue-500 text-blue-500 bg-white hover:bg-blue-50 transition-all text-sm font-medium">
                    <i class="fas fa-search"></i> Search
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.invoices.index') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </form>
            <a href="{{ route('admin.invoices.trash') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                <i class="fas fa-trash"></i> Trash
            </a>
            <a href="{{ route('admin.invoices.create') }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-medium shadow">
                <i class="fas fa-plus"></i> Create New Invoice
            </a>
        </div>
    </div>

    @if(session('success'))
        <div id="success-alert" class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div id="error-alert" class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-50 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Info</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Date</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                    <tr>
                        <td class="px-4 py-2 text-center">#{{ $invoice->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold">{{ $invoice->customer_name }}</div>
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-envelope"></i> {{ $invoice->customer_email }}<br>
                                <i class="fas fa-phone"></i> {{ $invoice->customer_phone }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->purchase_date->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($invoice->total_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = match(strtolower($invoice->status)) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'recheck' => 'bg-blue-100 text-blue-800',
                                    'done' => 'bg-green-100 text-green-800',
                                    'cancel' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-200 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($invoice->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 mr-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(strtolower($invoice->status) !== 'done')
                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to move this invoice to trash?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        document.querySelectorAll('#success-alert, #error-alert').forEach(function(element) {
            if (element) element.style.display = 'none';
        });
    }, 5000);
</script>
@endpush
@endsection
