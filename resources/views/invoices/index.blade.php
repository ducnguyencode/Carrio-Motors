@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Quản lý hóa đơn</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tạo hóa đơn mới
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Danh sách hóa đơn</h5>
        </div>
        <div class="card-body">
            @if(count($invoices) > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Ngày mua</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Người tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->buyer_name }}</td>
                            <td>{{ $invoice->purchase_date->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($invoice->total_price, 0, ',', '.') }} VNĐ</td>
                            <td>
                                @if($invoice->payment_method == 'cash')
                                    <span class="badge bg-success">Tiền mặt</span>
                                @elseif($invoice->payment_method == 'credit')
                                    <span class="badge bg-info">Thẻ tín dụng</span>
                                @elseif($invoice->payment_method == 'installment')
                                    <span class="badge bg-warning">Trả góp</span>
                                @else
                                    <span class="badge bg-secondary">{{ $invoice->payment_method }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge
                                    @if($invoice->process_status == 'deposit') bg-warning
                                    @elseif($invoice->process_status == 'payment' || $invoice->process_status == 'warehouse') bg-info
                                    @elseif($invoice->process_status == 'success') bg-success
                                    @elseif($invoice->process_status == 'cancel') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    @switch($invoice->process_status)
                                        @case('deposit')
                                            Đặt cọc
                                            @break
                                        @case('payment')
                                            Đã thanh toán
                                            @break
                                        @case('warehouse')
                                            Xuất kho
                                            @break
                                        @case('success')
                                            Hoàn thành
                                            @break
                                        @case('cancel')
                                            Hủy bỏ
                                            @break
                                        @default
                                            {{ $invoice->process_status }}
                                    @endswitch
                                </span>
                            </td>
                            <td>{{ $invoice->user->username ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteInvoice{{ $invoice->id }}" data-bs-toggle="tooltip" title="Hủy bỏ">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal xác nhận hủy -->
                                <div class="modal fade" id="deleteInvoice{{ $invoice->id }}" tabindex="-1" aria-labelledby="deleteInvoiceLabel{{ $invoice->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteInvoiceLabel{{ $invoice->id }}">Xác nhận hủy hóa đơn</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn hủy hóa đơn #{{ $invoice->id }} không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $invoices->links() }}
            </div>
            @else
            <div class="alert alert-info">
                Chưa có hóa đơn nào trong hệ thống.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Kích hoạt tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection
