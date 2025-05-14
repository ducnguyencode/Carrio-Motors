@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa hóa đơn #{{ $invoice->id }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Khách hàng</label>
                            <p class="form-control-static">{{ $invoice->customer->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saler_id">Nhân viên bán hàng</label>
                            <select class="form-control select2" name="saler_id" id="saler_id">
                                <option value="">Chọn nhân viên</option>
                                @foreach($salers as $saler)
                                    <option value="{{ $saler->id }}" {{ $invoice->saler_id == $saler->id ? 'selected' : '' }}>
                                        {{ $saler->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Trạng thái <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $invoice->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="completed" {{ $invoice->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="canceled" {{ $invoice->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value="cash" {{ $invoice->payment_method == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                                <option value="bank_transfer" {{ $invoice->payment_method == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                                <option value="credit_card" {{ $invoice->payment_method == 'credit_card' ? 'selected' : '' }}>Thẻ tín dụng</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="shipping_address">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="shipping_address" id="shipping_address" rows="3" required>{{ $invoice->shipping_address }}</textarea>
                </div>

                <div class="form-group">
                    <label>Chi tiết sản phẩm</label>
                    <div class="table-responsive">
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
                </div>

                <div class="form-group">
                    <label for="notes">Ghi chú</label>
                    <textarea class="form-control" name="notes" id="notes" rows="3">{{ $invoice->notes }}</textarea>
                </div>

                <div class="text-right mt-3">
                    <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
