@extends('admin.layouts.app')

@section('title', 'Invoice Details')

@section('page-heading', 'Invoice Details')

@php
    // Set flag to prevent duplicate flash messages from layout
    $hideFlashMessages = true;
@endphp

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Invoice #{{ $invoice->id }}</h2>
        <div class="flex items-center gap-2">
            @if(strtolower($invoice->status) !== 'done')
            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="flex items-center gap-1 px-4 py-2 rounded-full bg-yellow-500 text-white hover:bg-yellow-600 transition-all text-sm font-medium shadow">
                <i class="fas fa-edit"></i> Edit Invoice
            </a>
            @endif
            <a href="{{ route('admin.invoices.index') }}" class="flex items-center gap-1 px-4 py-2 rounded-full border border-gray-500 text-gray-500 bg-white hover:bg-gray-50 transition-all text-sm font-medium">
                <i class="fas fa-arrow-left"></i> Back to List
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h3 class="text-md font-semibold text-gray-700">Customer Information</h3>
            </div>
            <div class="p-4">
                <div class="mb-3">
                    <strong class="text-gray-700">Name:</strong>
                    <p>{{ $invoice->customer_name }}</p>
                </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Email:</strong>
                    <p>{{ $invoice->customer_email }}</p>
                    </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Phone:</strong>
                    <p>{{ $invoice->customer_phone }}</p>
                    </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Address:</strong>
                    <p>{{ $invoice->customer_address }}</p>
                    </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Seller Tax Code:</strong>
                    <p>{{ $invoice->seller_tax_code }}</p>
                    </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Customer Tax Code:</strong>
                    <p>{{ $invoice->customer_tax_code ?? 'Not provided' }}</p>
                    </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Tax Rate:</strong>
                    <p>{{ $invoice->tax_rate }}%</p>
                    </div>
                    <div class="mb-3">
                    <strong class="text-gray-700">Payment Method:</strong>
                    <p>{{ ucfirst($invoice->payment_method) }}</p>
                    </div>
                <div>
                    <strong class="text-gray-700">Status:</strong>
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
                </div>

                <div class="mt-3 pt-3 border-t border-gray-200">
                    <strong class="text-gray-700">Linked User Account:</strong>
                    @if($invoice->user)
                        <div class="mt-2 flex items-center">
                            <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                <i class="fas fa-user text-gray-500 w-full h-full flex items-center justify-center"></i>
                            </span>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $invoice->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $invoice->user->email }}</p>
                            </div>
                            <a href="{{ route('admin.users.show', $invoice->user->id) }}" class="ml-2 px-2 py-1 text-xs rounded bg-blue-100 text-blue-700 hover:bg-blue-200">
                                <i class="fas fa-external-link-alt mr-1"></i> View User
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">No user account linked</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h3 class="text-md font-semibold text-gray-700">Invoice Details</h3>
                </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                                <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->invoiceDetails as $detail)
                                    <tr>
                                    <td class="px-4 py-2">{{ $detail->carDetail->car->name }}</td>
                                    <td class="px-4 py-2">{{ $detail->carDetail->carColor->name }}</td>
                                    <td class="px-4 py-2">{{ $detail->quantity }}</td>
                                    <td class="px-4 py-2">${{ number_format($detail->price, 2) }}</td>
                                    <td class="px-4 py-2">${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="px-4 py-2 text-right font-semibold">Subtotal:</th>
                                    <th class="px-4 py-2 font-semibold">${{ number_format($invoice->total_price, 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="px-4 py-2 text-right font-semibold">Tax ({{ $invoice->tax_rate }}%):</th>
                                    <th class="px-4 py-2 font-semibold">${{ number_format($invoice->tax_amount, 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="px-4 py-2 text-right font-semibold">Total:</th>
                                    <th class="px-4 py-2 font-semibold">${{ number_format($invoice->total_price + $invoice->tax_amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
