@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Chỉnh sửa hóa đơn #{{ $invoice->id }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Quản lý hóa đơn</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('invoices.show', $invoice->id) }}">Chi tiết #{{ $invoice->id }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Thông tin hóa đơn</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoice-form">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Thông tin khách hàng</h4>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buyer_name" class="form-label">Tên khách hàng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="{{ old('buyer_name', $invoice->buyer_name) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buyer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="buyer_email" name="buyer_email" value="{{ old('buyer_email', $invoice->buyer_email) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buyer_phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="buyer_phone" name="buyer_phone" value="{{ old('buyer_phone', $invoice->buyer_phone) }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Phương thức thanh toán</h4>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" {{ $invoice->payment_method == 'cash' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_cash">
                                    Tiền mặt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_credit" value="credit" {{ $invoice->payment_method == 'credit' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_credit">
                                    Thẻ tín dụng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_installment" value="installment" {{ $invoice->payment_method == 'installment' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_installment">
                                    Trả góp
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Trạng thái đơn hàng</h4>
                        <select name="process_status" class="form-select">
                            <option value="deposit" {{ $invoice->process_status == 'deposit' ? 'selected' : '' }}>Đặt cọc</option>
                            <option value="payment" {{ $invoice->process_status == 'payment' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="warehouse" {{ $invoice->process_status == 'warehouse' ? 'selected' : '' }}>Xuất kho</option>
                            <option value="success" {{ $invoice->process_status == 'success' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancel" {{ $invoice->process_status == 'cancel' ? 'selected' : '' }}>Hủy bỏ</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4>Chi tiết sản phẩm</h4>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Chi tiết sản phẩm không thể chỉnh sửa sau khi hóa đơn đã được tạo. Nếu cần thay đổi, vui lòng hủy hóa đơn này và tạo hóa đơn mới.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
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

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
