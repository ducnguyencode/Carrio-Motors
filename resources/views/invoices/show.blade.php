@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Chi tiết hóa đơn #{{ $invoice->id }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Quản lý hóa đơn</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết #{{ $invoice->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Thông tin hóa đơn</h5>
                    <div class="btn-group">
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelInvoiceModal">
                            <i class="fas fa-ban"></i> Hủy hóa đơn
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Thông tin cơ bản</h6>
                            <p><strong>Ngày tạo:</strong> {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Ngày mua:</strong> {{ $invoice->purchase_date->format('d/m/Y H:i') }}</p>
                            <p>
                                <strong>Trạng thái:</strong>
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
                            </p>
                            <p>
                                <strong>Phương thức thanh toán:</strong>
                                @if($invoice->payment_method == 'cash')
                                    <span class="badge bg-success">Tiền mặt</span>
                                @elseif($invoice->payment_method == 'credit')
                                    <span class="badge bg-info">Thẻ tín dụng</span>
                                @elseif($invoice->payment_method == 'installment')
                                    <span class="badge bg-warning">Trả góp</span>
                                @else
                                    <span class="badge bg-secondary">{{ $invoice->payment_method }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Thông tin khách hàng</h6>
                            <p><strong>Tên:</strong> {{ $invoice->buyer_name }}</p>
                            <p><strong>Email:</strong> {{ $invoice->buyer_email ?? 'N/A' }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $invoice->buyer_phone ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <h6 class="fw-bold">Chi tiết sản phẩm</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mẫu xe</th>
                                    <th>Màu sắc</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->details as $detail)
                                <tr>
                                    <td>{{ $detail->carDetail->car->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($detail->carDetail->carColor)
                                            <span class="d-inline-block me-1" style="width: 15px; height: 15px; background-color: {{ $detail->carDetail->carColor->hex_code }}; border-radius: 3px;"></span>
                                            {{ $detail->carDetail->carColor->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Tổng cộng:</th>
                                    <th>{{ number_format($invoice->total_price, 0, ',', '.') }} VNĐ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Cập nhật trạng thái</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.update-status', $invoice->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái mới</label>
                            <select name="status" id="status" class="form-select">
                                <option value="deposit" {{ $invoice->process_status == 'deposit' ? 'selected' : '' }}>Đặt cọc</option>
                                <option value="payment" {{ $invoice->process_status == 'payment' ? 'selected' : '' }}>Đã thanh toán</option>
                                <option value="warehouse" {{ $invoice->process_status == 'warehouse' ? 'selected' : '' }}>Xuất kho</option>
                                <option value="success" {{ $invoice->process_status == 'success' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancel" {{ $invoice->process_status == 'cancel' ? 'selected' : '' }}>Hủy bỏ</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cập nhật trạng thái</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Thông tin bổ sung</h5>
                </div>
                <div class="card-body">
                    <p><strong>Người tạo:</strong> {{ $invoice->user->fullname ?? $invoice->user->username ?? 'N/A' }}</p>
                    <p><strong>Cập nhật lần cuối:</strong> {{ $invoice->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận hủy -->
<div class="modal fade" id="cancelInvoiceModal" tabindex="-1" aria-labelledby="cancelInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelInvoiceModalLabel">Xác nhận hủy hóa đơn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy hóa đơn #{{ $invoice->id }} không? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
