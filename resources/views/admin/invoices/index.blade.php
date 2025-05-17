@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Invoices</h1>
        <div>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.invoices.trash') }}" class="btn btn-secondary">
                <i class="fas fa-trash"></i> Trash
            </a>
            @endif
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Invoice
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="{{ route('admin.invoices.index') }}" method="GET" class="d-flex align-items-center" id="searchForm">
                        <div class="input-group mr-3" style="width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>

                        <select name="status" class="form-control mr-3" style="width: 150px;" onchange="document.getElementById('searchForm').submit()">
                            <option value="">All Status</option>
                            @foreach(\App\Models\Invoice::getStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    @endif
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Info</th>
                            <th>Purchase Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>
                                    <strong>{{ $invoice->customer_name }}</strong><br>
                                    <small>
                                        <i class="fas fa-envelope"></i> {{ $invoice->customer_email }}<br>
                                        <i class="fas fa-phone"></i> {{ $invoice->customer_phone }}
                                    </small>
                                </td>
                                <td>{{ $invoice->purchase_date->format('Y-m-d H:i') }}</td>
                                <td>${{ number_format($invoice->total_price, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match(strtolower($invoice->status)) {
                                            'pending' => 'warning',
                                            'recheck' => 'info',
                                            'done' => 'success',
                                            'cancel' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst($invoice->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to move this invoice to trash?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} results
                    </div>
                    <div class="d-flex">
                        @if($invoices->previousPageUrl())
                            <a href="{{ $invoices->previousPageUrl() }}" class="btn btn-outline-primary mr-2">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        @else
                            <button class="btn btn-outline-primary mr-2" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @endif

                        @if($invoices->nextPageUrl())
                            <a href="{{ $invoices->nextPageUrl() }}" class="btn btn-outline-primary">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="btn btn-outline-primary" disabled>
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
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
