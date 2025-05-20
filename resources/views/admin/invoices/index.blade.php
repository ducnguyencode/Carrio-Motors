@extends('admin.layouts.app')

@section('page-heading', 'Invoices')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mt-6">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
        <form action="{{ route('admin.invoices.index') }}" method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" class="px-3 py-2 border rounded w-64" placeholder="Search by name or phone..." value="{{ request('search') }}">
            <select name="status" class="px-3 py-2 border rounded w-40" onchange="this.form.submit()">
                <option value="">All Status</option>
                @foreach(\App\Models\Invoice::getStatuses() as $value => $label)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" type="submit">
                <i class="fas fa-search"></i> Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.invoices.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
        <div class="flex gap-2">
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.invoices.trash') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 flex items-center">
                <i class="fas fa-trash mr-2"></i> Trash
            </a>
            @endif
            <a href="{{ route('admin.invoices.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i> Create New Invoice
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Info</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">#{{ $invoice->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold">{{ $invoice->customer_name }}</div>
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-envelope"></i> {{ $invoice->customer_email }}<br>
                                <i class="fas fa-phone"></i> {{ $invoice->customer_phone }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $invoice->purchase_date->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">${{ number_format($invoice->total_price, 2) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusClass = match(strtolower($invoice->status)) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'recheck' => 'bg-blue-100 text-blue-800',
                                    'done' => 'bg-green-100 text-green-800',
                                    'cancel' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-200 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClass }}">
                                {{ ucfirst($invoice->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap flex gap-1">
                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="inline-block px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="inline-block px-2 py-1 bg-blue-400 text-white rounded hover:bg-blue-500" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" title="Delete" onclick="return confirm('Are you sure you want to move this invoice to trash?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-4">
        <div class="text-gray-500">
            Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} results
        </div>
        <div>
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush