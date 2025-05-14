@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết hóa đơn #{{ $invoice->id }}</h6>
            <div>
                <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <button onclick="window.print()" class="btn btn-info btn-sm">
                    <i class="fas fa-print"></i> In
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="mb-3">Thông tin khách hàng</h5>
                    <p><strong>Tên:</strong> {{ $invoice->customer->name }}</p>
                    <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $invoice->customer->phone }}</p>
                    <p><strong>Địa chỉ giao hàng:</strong> {{ $invoice->shipping_address }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Thông tin hóa đơn</h5>
                    <p><strong>Mã hóa đơn:</strong> #{{ $invoice->id }}</p>
                    <p><strong>Ngày tạo:</strong> {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong>
                        <span class="badge badge-{{ $invoice->status_color }}">
                            {{ $invoice->status_text }}
                        </span>
                    </p>
                    <p><strong>Nhân viên bán hàng:</strong>
                        {{ $invoice->saler ? $invoice->saler->name : 'N/A' }}
                    </p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $invoice->payment_method_text }}</p>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center" width="100">Số lượng</th>
                            <th class="text-right" width="200">Đơn giá</th>
                            <th class="text-right" width="200">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->details as $detail)
                        <tr>
                            <td>
                                {{ $detail->carDetail->car->name }} -
                                {{ $detail->carDetail->carColor->name }}
                            </td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td class="text-right">
                                {{ number_format($detail->unit_price, 0, ',', '.') }} VNĐ
                            </td>
                            <td class="text-right">
                                {{ number_format($detail->subtotal, 0, ',', '.') }} VNĐ
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                            <td class="text-right">
                                <strong>{{ number_format($invoice->total_amount, 0, ',', '.') }} VNĐ</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($invoice->notes)
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Ghi chú</h5>
                    <p class="mb-0">{{ $invoice->notes }}</p>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Lịch sử hoạt động</h5>
                    <div class="timeline">
                        @foreach($invoice->activities()->with('causer')->latest()->get() as $activity)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">
                                    {{ $activity->description }}
                                    @if($activity->causer)
                                    bởi {{ $activity->causer->name }}
                                    @endif
                                </h6>
                                <p class="timeline-date">{{ $activity->created_at->format('d/m/Y H:i') }}</p>
                                @if($activity->properties->count() > 0)
                                <div class="timeline-extra">
                                    @foreach($activity->properties as $key => $value)
                                    <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-right mt-4">
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                @if($invoice->status !== 'completed')
                <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .timeline {
            display: none;
        }
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 20px;
    }

    .timeline-marker {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #4e73df;
        background: #fff;
        margin-right: 15px;
        flex-shrink: 0;
        margin-top: 5px;
    }

    .timeline-content {
        flex-grow: 1;
    }

    .timeline-title {
        margin: 0;
        color: #4e73df;
    }

    .timeline-date {
        color: #858796;
        font-size: 0.875rem;
        margin: 5px 0;
    }

    .timeline-extra {
        background: #f8f9fc;
        padding: 10px;
        border-radius: 4px;
        margin-top: 10px;
    }
</style>
@endsection
