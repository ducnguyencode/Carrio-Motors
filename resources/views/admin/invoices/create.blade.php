@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tạo hóa đơn mới</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.invoices.store') }}" method="POST" id="createInvoiceForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id">Khách hàng <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="customer_id" id="customer_id" required>
                                <option value="">Chọn khách hàng</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->email }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saler_id">Nhân viên bán hàng</label>
                            <select class="form-control select2" name="saler_id" id="saler_id">
                                <option value="">Chọn nhân viên</option>
                                @foreach($salers as $saler)
                                    <option value="{{ $saler->id }}">{{ $saler->name }}</option>
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
                                <option value="pending">Chờ xử lý</option>
                                <option value="processing">Đang xử lý</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="canceled">Đã hủy</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value="cash">Tiền mặt</option>
                                <option value="bank_transfer">Chuyển khoản</option>
                                <option value="credit_card">Thẻ tín dụng</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="shipping_address">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="shipping_address" id="shipping_address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>Sản phẩm <span class="text-danger">*</span></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="products_table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th width="150">Số lượng</th>
                                    <th width="200">Đơn giá</th>
                                    <th width="200">Thành tiền</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control select2 product-select" name="car_details[0][id]" required>
                                            <option value="">Chọn sản phẩm</option>
                                            @foreach($carDetails as $carDetail)
                                                <option value="{{ $carDetail->id }}" data-price="{{ $carDetail->price }}">
                                                    {{ $carDetail->car->name }} - {{ $carDetail->carColor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="car_details[0][quantity]" class="form-control quantity" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control unit-price" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control subtotal" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-product">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success" id="add_product">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="notes">Ghi chú</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Tổng cộng</h5>
                                <div class="row">
                                    <div class="col-sm-6">Tổng tiền hàng:</div>
                                    <div class="col-sm-6 text-right" id="total_amount">0 VNĐ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();

        // Add product row
        $('#add_product').click(function() {
            let row = $('#products_table tbody tr:first').clone();
            let index = $('#products_table tbody tr').length;

            row.find('select').attr('name', `car_details[${index}][id]`).val('');
            row.find('.quantity').attr('name', `car_details[${index}][quantity]`).val(1);
            row.find('.unit-price, .subtotal').val('');

            $('#products_table tbody').append(row);
            row.find('.select2').select2();
        });

        // Remove product row
        $(document).on('click', '.remove-product', function() {
            if ($('#products_table tbody tr').length > 1) {
                $(this).closest('tr').remove();
                calculateTotal();
            }
        });

        // Calculate subtotal when product or quantity changes
        $(document).on('change', '.product-select, .quantity', function() {
            let row = $(this).closest('tr');
            let price = row.find('.product-select option:selected').data('price') || 0;
            let quantity = row.find('.quantity').val();

            row.find('.unit-price').val(formatCurrency(price));
            row.find('.subtotal').val(formatCurrency(price * quantity));

            calculateTotal();
        });

        // Calculate total amount
        function calculateTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseCurrency($(this).val());
            });
            $('#total_amount').text(formatCurrency(total) + ' VNĐ');
        }

        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        // Parse currency string to number
        function parseCurrency(str) {
            return parseInt(str.replace(/[^\d]/g, '')) || 0;
        }

        // Form validation
        $('#createInvoiceForm').submit(function(e) {
            let valid = true;
            $('.product-select').each(function() {
                if (!$(this).val()) {
                    alert('Vui lòng chọn sản phẩm cho tất cả các dòng');
                    valid = false;
                    return false;
                }
            });
            return valid;
        });
    });
</script>
@endpush
