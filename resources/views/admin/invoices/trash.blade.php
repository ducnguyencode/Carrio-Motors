@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Trashed Invoices</h1>
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Invoices
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Info</th>
                            <th>Purchase Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Deleted At</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashedInvoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>
                                    <strong>{{ $invoice->customer_name }}</strong><br>
                                    <small><i class="fas fa-envelope"></i> {{ $invoice->customer_email }}</small><br>
                                    <small><i class="fas fa-phone"></i> {{ $invoice->customer_phone }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($invoice->purchase_date)->format('Y-m-d H:i') }}</td>
                                <td>${{ number_format($invoice->total_price, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match($invoice->status) {
                                            'pending' => 'warning',
                                            'recheck' => 'info',
                                            'done' => 'success',
                                            'cancel' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>{{ $invoice->deleted_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form action="{{ route('admin.invoices.restore', $invoice->id) }}"
                                              method="POST"
                                              class="restore-form">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Restore Invoice">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.invoices.force-delete', $invoice->id) }}"
                                              method="POST"
                                              class="force-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Permanently Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No trashed invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $trashedInvoices->links() }}
            </div>
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
