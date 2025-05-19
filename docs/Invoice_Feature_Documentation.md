# Tài Liệu Tính Năng Hóa Đơn

## Tổng Quan
Tài liệu này mô tả việc triển khai tính năng Hóa Đơn trong hệ thống Carrio Motors, bao gồm cả chức năng thùng rác.

## Tính Năng
1. Quản Lý Hóa Đơn
   - Tạo, xem, cập nhật và xóa hóa đơn
   - Chức năng xóa mềm (chuyển vào thùng rác)
   - Tìm kiếm theo số điện thoại và tên khách hàng (hỗ trợ tiếng Việt có dấu)
   - Quản lý trạng thái (đang chờ, kiểm tra lại, hoàn thành, hủy)

2. Phân Quyền Người Dùng
   - Admin: Toàn quyền (bao gồm quản lý thùng rác)
   - Saler: Quản lý hóa đơn cơ bản (tạo, xem, cập nhật, xóa mềm)

## Chi Tiết Kỹ Thuật

### Routes
```php
// Routes chỉ dành cho Admin (quản lý thùng rác)
Route::get('invoices/trash', [AdminInvoiceController::class, 'trash'])->name('invoices.trash');
Route::post('invoices/{id}/restore', [AdminInvoiceController::class, 'restore'])->name('invoices.restore');
Route::delete('invoices/{id}/force-delete', [AdminInvoiceController::class, 'forceDelete'])->name('invoices.force-delete');

// Routes cho Admin và Saler (quản lý cơ bản)
Route::resource('invoices', AdminInvoiceController::class)->except(['trash', 'restore', 'forceDelete']);
Route::put('/invoices/{id}/status', [AdminInvoiceController::class, 'updateStatus'])->name('invoices.update-status');
```

### Cơ Sở Dữ Liệu
- Bảng Invoices có tính năng xóa mềm
- Trường trạng thái với các tùy chọn: đang chờ, kiểm tra lại, hoàn thành, hủy
- Quan hệ với bảng users, cars và các bảng liên quan khác

### Giao Diện
- `index.blade.php`: Danh sách hóa đơn chính
- `trash.blade.php`: Danh sách hóa đơn đã xóa
- `create.blade.php`: Form tạo hóa đơn
- `edit.blade.php`: Form chỉnh sửa hóa đơn

### Chức Năng Tìm Kiếm
- Hỗ trợ tìm kiếm theo số điện thoại và tên khách hàng
- Xử lý tiếng Việt có dấu bằng StringHelper

## Hướng Dẫn Sử Dụng

### Dành Cho Admin
1. Truy cập quản lý hóa đơn tại `/admin/invoices`
2. Xem hóa đơn đã xóa tại `/admin/invoices/trash`
3. Khôi phục hoặc xóa vĩnh viễn hóa đơn trong thùng rác
4. Quản lý tất cả hóa đơn không phân biệt người tạo

### Dành Cho Saler
1. Truy cập quản lý hóa đơn tại `/admin/invoices`
2. Tạo hóa đơn mới
3. Cập nhật hóa đơn hiện có
4. Xóa mềm (chuyển vào thùng rác) các hóa đơn của mình
5. Không thể truy cập thùng rác hoặc xóa vĩnh viễn hóa đơn

## Lưu Ý
- Đảm bảo phân quyền đúng cho người dùng
- Khuyến nghị sao lưu dữ liệu thường xuyên
- Theo dõi log hệ thống để phát hiện sự cố 
