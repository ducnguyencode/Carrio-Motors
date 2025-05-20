@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Trashed Invoices</h1>
            <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                <i class="fas fa-arrow-left mr-2"></i> Back to Invoices
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b text-left">ID</th>
                        <th class="px-4 py-2 border-b text-left">Customer Info</th>
                        <th class="px-4 py-2 border-b text-left">Purchase Date</th>
                        <th class="px-4 py-2 border-b text-left">Total Price</th>
                        <th class="px-4 py-2 border-b text-left">Status</th>
                        <th class="px-4 py-2 border-b text-left">Deleted At</th>
                        <th class="px-4 py-2 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedInvoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $invoice->id }}</td>
                            <td class="px-4 py-2 border-b">
                                <div class="font-semibold">{{ $invoice->customer_name }}</div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-envelope"></i> {{ $invoice->customer_email }}<br>
                                    <i class="fas fa-phone"></i> {{ $invoice->customer_phone }}
                                </div>
                            </td>
                            <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($invoice->purchase_date)->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 border-b">${{ number_format($invoice->total_price, 2) }}</td>
                            <td class="px-4 py-2 border-b">
                                @php
                                    $statusClass = match($invoice->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'recheck' => 'bg-blue-100 text-blue-800',
                                        'done' => 'bg-green-100 text-green-800',
                                        'cancel' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-200 text-gray-800'
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border-b">{{ $invoice->deleted_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 border-b">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.invoices.restore', $invoice->id) }}" method="POST" class="restore-form">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" title="Restore Invoice">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.invoices.force-delete', $invoice->id) }}" method="POST" class="force-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600" title="Permanently Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">No trashed invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            {{ $trashedInvoices->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Handle restore confirmation
    $('.restore-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Restore Invoice?',
            text: "The invoice will be restored and visible in the main list.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Handle permanent delete confirmation
    $('.force-delete-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Delete Permanently?',
            text: "You won't be able to recover this invoice!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete permanently!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush
@endsection
