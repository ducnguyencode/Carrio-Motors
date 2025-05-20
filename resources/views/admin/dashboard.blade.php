@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-heading', 'Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Users -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Users</p>
                <p class="text-2xl font-semibold">{{ number_format($totalUsers) }}</p>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Cars -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-car text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Cars</p>
                <p class="text-2xl font-semibold">{{ number_format($totalCars) }}</p>
            </div>
        </div>
    </div>

    <!-- Card 3: New Orders -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">New Orders (Today)</p>
                <p class="text-2xl font-semibold">{{ number_format($newOrdersToday) }}</p>
            </div>
        </div>
    </div>

    <!-- Card 4: Monthly Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-dollar-sign text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Monthly Revenue</p>
                <p class="text-2xl font-semibold">{{ number_format($revenueThisMonth, 0, ',', '.') }} $</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Chart: Monthly Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Monthly Revenue</h2>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Recent Orders</h2>
            <a href="{{ route('admin.invoices.index') }}" class="text-blue-500 hover:text-blue-700">View All</a>
        </div>

        @if(isset($recentInvoices) && $recentInvoices->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentInvoices as $invoice)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-blue-500 hover:text-blue-700">
                                        #{{ $invoice->id }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="font-semibold">{{ $invoice->customer_name ?? $invoice->buyer_name ?? '-' }}</div>
                                    @if(!empty($invoice->customer_email) || !empty($invoice->customer_phone))
                                        <div class="text-xs text-gray-500">
                                            @if(!empty($invoice->customer_email))
                                                <i class="fas fa-envelope"></i> {{ $invoice->customer_email }}<br>
                                            @endif
                                            @if(!empty($invoice->customer_phone))
                                                <i class="fas fa-phone"></i> {{ $invoice->customer_phone }}
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $invoice->purchase_date ? \Carbon\Carbon::parse($invoice->purchase_date)->format('d/m/Y') : ($invoice->created_at ? $invoice->created_at->format('d/m/Y') : '-') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $status = $invoice->status ?? $invoice->process_status ?? null;
                                        $statusClass = match($status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'recheck' => 'bg-blue-100 text-blue-800',
                                            'done', 'success' => 'bg-green-100 text-green-800',
                                            'cancel' => 'bg-red-100 text-red-800',
                                            'deposit' => 'bg-yellow-100 text-yellow-800',
                                            'payment' => 'bg-blue-100 text-blue-800',
                                            'warehouse' => 'bg-indigo-100 text-indigo-800',
                                            default => 'bg-gray-200 text-gray-800'
                                        };
                                    @endphp
                                    @if($status)
                                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ number_format($invoice->total_price, 0, ',', '.') }} $</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No recent orders found.</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Monthly Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Revenue ($)',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: 'rgba(99, 102, 241, 0.6)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('en-US').format(value) + ' $';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('en-US').format(context.raw) + ' $';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
