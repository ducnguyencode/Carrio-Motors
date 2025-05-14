<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chi tiết hóa đơn #{{ $invoice->id }}
            </h2>
            <div class="flex space-x-2">
                @if($invoice->status !== 'completed' && $invoice->status !== 'cancelled')
                    <a href="{{ route('invoices.edit', $invoice) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Chỉnh sửa
                    </a>
                @endif
                <a href="{{ route('invoices.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Quay lại
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600">Customer Name:</span>
                                    <span class="font-medium">{{ $invoice->customer_name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $invoice->customer_email }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Số điện thoại:</span>
                                    <span class="font-medium">{{ $invoice->customer_phone }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Địa chỉ:</span>
                                    <span class="font-medium">{{ $invoice->customer_address }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600">Phương thức thanh toán:</span>
                                    <span class="font-medium">
                                        @switch($invoice->payment_method)
                                            @case('cash')
                                                Tiền mặt
                                                @break
                                            @case('bank_transfer')
                                                Chuyển khoản
                                                @break
                                            @case('credit_card')
                                                Thẻ tín dụng
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Trạng thái:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($invoice->status === 'completed') bg-green-100 text-green-800
                                        @elseif($invoice->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        @switch($invoice->status)
                                            @case('deposit')
                                                Đặt cọc
                                                @break
                                            @case('paid')
                                                Paid
                                                @break
                                            @case('processing')
                                                Đang xử lý
                                                @break
                                            @case('completed')
                                                Hoàn thành
                                                @break
                                            @case('cancelled')
                                                Cancelled
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Ngày tạo:</span>
                                    <span class="font-medium">{{ $invoice->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Car Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Car Details</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->details as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $detail->car->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($detail->unit_price, 0, ',', '.') }} VNĐ</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $detail->quantity }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($detail->subtotal, 0, ',', '.') }} VNĐ</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-6 py-4 text-right font-medium">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ number_format($invoice->total_price, 0, ',', '.') }} VNĐ</div>
                                    </td>
                                </tr>
                                @if($invoice->discount_amount > 0)
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-6 py-4 text-right font-medium">Discount:</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">-{{ number_format($invoice->discount_amount, 0, ',', '.') }} VNĐ</div>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-6 py-4 text-right font-medium">Final Price:</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900">{{ number_format($invoice->final_price, 0, ',', '.') }} VNĐ</div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($invoice->status !== 'completed' && $invoice->status !== 'cancelled')
                <!-- Update Status -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
                        <form action="{{ route('invoices.update-status', $invoice) }}" method="POST" class="flex items-center space-x-4">
                            @csrf
                            @method('PUT')
                            <select name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="deposit" {{ $invoice->status === 'deposit' ? 'selected' : '' }}>Đặt cọc</option>
                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="processing" {{ $invoice->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="completed" {{ $invoice->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Hủy</option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
