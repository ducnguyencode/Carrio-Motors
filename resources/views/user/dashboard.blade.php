@extends('admin.layouts.app')

@section('title', 'My Dashboard')

@section('page-heading', 'My Dashboard')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow p-4">
                <h2 class="mb-3">Welcome, {{ $user->fullname ?? $user->name }}</h2>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone }}</p>
                <p><strong>Address:</strong> {{ $user->address }}</p>
                <p><strong>Email Verified:</strong> {!! $user->hasVerifiedEmail() ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-warning text-dark">Not Verified</span>' !!}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow p-4">
                <h3 class="mb-3">My Invoices</h3>
                @if($invoices->count())
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>#{{ $invoice->id }}</td>
                                        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($invoice->process_status == 'deposit')
                                                <span class="badge bg-warning text-dark">Deposit</span>
                                            @elseif($invoice->process_status == 'payment')
                                                <span class="badge bg-info text-dark">Payment</span>
                                            @elseif($invoice->process_status == 'warehouse')
                                                <span class="badge bg-primary">Warehouse</span>
                                            @elseif($invoice->process_status == 'success')
                                                <span class="badge bg-success">Success</span>
                                            @elseif($invoice->process_status == 'cancel')
                                                <span class="badge bg-danger">Cancel</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($invoice->total_price, 0, ',', '.') }} $</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">You have no invoices yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
