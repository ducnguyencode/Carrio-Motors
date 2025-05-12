@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Tạo hóa đơn mới</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Quản lý hóa đơn</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
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
            <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Thông tin khách hàng</h4>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buyer_name" class="form-label">Tên khách hàng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="{{ old('buyer_name') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buyer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="buyer_email" name="buyer_email" value="{{ old('buyer_email') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buyer_phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="buyer_phone" name="buyer_phone" value="{{ old('buyer_phone') }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Phương thức thanh toán</h4>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    Tiền mặt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_credit" value="credit">
                                <label class="form-check-label" for="payment_credit">
                                    Thẻ tín dụng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_installment" value="installment">
                                <label class="form-check-label" for="payment_installment">
                                    Trả góp
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Chi tiết xe <button type="button" id="add-car-btn" class="btn btn-sm btn-primary ms-2"><i class="fas fa-plus"></i> Thêm xe</button></h4>
                    </div>
                </div>

                <div id="car-items-container">
                    <div class="car-item card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Chọn xe và màu <span class="text-danger">*</span></label>
                                    <select name="items[0][car_detail_id]" class="form-select car-detail-select" required>
                                        <option value="">-- Chọn xe --</option>
                                        <!-- Sẽ được điền bằng Ajax -->
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                    <input type="number" name="items[0][quantity]" class="form-control item-quantity" min="1" value="1" required>
                                </div>
                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-car-btn" disabled><i class="fas fa-trash"></i> Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tải danh sách xe khi trang được tải
        loadCarDetails();

        // Thêm xe mới
        document.getElementById('add-car-btn').addEventListener('click', function() {
            addCarItem();
        });

        // Đăng ký sự kiện cho nút xóa
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-car-btn') || e.target.closest('.remove-car-btn')) {
                const button = e.target.classList.contains('remove-car-btn') ? e.target : e.target.closest('.remove-car-btn');
                removeCarItem(button);
            }
        });
    });

    // Biến đếm số lượng mục
    let itemCount = 1;

    // Tải danh sách chi tiết xe
    function loadCarDetails() {
        // Giả vờ có dữ liệu từ server (trong thực tế, bạn nên thay thế bằng một cuộc gọi AJAX)
        const selects = document.querySelectorAll('.car-detail-select');
        selects.forEach(select => {
            // Thêm các tùy chọn mẫu (thay bằng dữ liệu thực từ AJAX)
            select.innerHTML = `
                <option value="">-- Chọn xe --</option>
                <option value="1">Toyota Camry - Trắng</option>
                <option value="2">Toyota Camry - Đen</option>
                <option value="3">Honda Civic - Đỏ</option>
                <option value="4">Honda Civic - Xanh</option>
                <option value="5">Ford Ranger - Bạc</option>
            `;
        });
    }

    // Thêm mục xe mới
    function addCarItem() {
        const container = document.getElementById('car-items-container');
        const newItem = document.createElement('div');
        newItem.className = 'car-item card mb-3';
        newItem.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Chọn xe và màu <span class="text-danger">*</span></label>
                        <select name="items[${itemCount}][car_detail_id]" class="form-select car-detail-select" required>
                            <option value="">-- Chọn xe --</option>
                            <!-- Sẽ được điền bằng Ajax -->
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" name="items[${itemCount}][quantity]" class="form-control item-quantity" min="1" value="1" required>
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-car-btn"><i class="fas fa-trash"></i> Xóa</button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newItem);

        // Tải dữ liệu cho select mới
        loadCarDetails();

        // Tăng biến đếm
        itemCount++;

        // Kích hoạt nút Xóa cho tất cả các mục nếu có nhiều hơn 1
        toggleRemoveButtons();
    }

    // Xóa mục xe
    function removeCarItem(button) {
        const item = button.closest('.car-item');
        item.remove();

        // Cập nhật các chỉ số
        updateItemIndices();

        // Kích hoạt/Vô hiệu hóa nút Xóa
        toggleRemoveButtons();
    }

    // Cập nhật chỉ số cho các mục
    function updateItemIndices() {
        const items = document.querySelectorAll('.car-item');
        items.forEach((item, index) => {
            const select = item.querySelector('select');
            const quantity = item.querySelector('input[type="number"]');

            select.name = `items[${index}][car_detail_id]`;
            quantity.name = `items[${index}][quantity]`;
        });

        // Cập nhật biến đếm
        itemCount = items.length;
    }

    // Bật/tắt nút xóa dựa trên số lượng mục
    function toggleRemoveButtons() {
        const items = document.querySelectorAll('.car-item');
        const buttons = document.querySelectorAll('.remove-car-btn');

        buttons.forEach(button => {
            button.disabled = items.length <= 1;
        });
    }
</script>
@endsection
