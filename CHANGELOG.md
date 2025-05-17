# Changelog

## [1.0.0] - 2024-03-21

### Thay đổi Cấu Trúc Database
- Thay đổi từ `car_id` sang `car_detail_id` trong bảng `invoice_details`
- Cập nhật các model để phản ánh mối quan hệ mới

### Cập Nhật Model
1. **Car Model**
   - Đổi tên trường `brain` thành `brand`
   - Đổi tên trường `seat_number` thành `seats`
   - Đổi tên trường `isActive` thành `status`
   - Cập nhật relationship `model()` để trỏ đến `CarModel`

2. **Invoice Model**
   - Thêm relationship `saler()` để liên kết với người bán

3. **InvoiceDetail Model**
   - Thêm relationship `carDetail()` để liên kết với thông tin chi tiết xe

### Dữ Liệu Mẫu
- Đã thêm TestDataSeeder với dữ liệu mẫu Toyota Camry XSE:
  - Động cơ 2.5L Dynamic Force
  - 3 màu sắc khác nhau
  - Mỗi màu có 5 xe trong kho
  - Giá: $35,000/xe

### Lưu Ý Cho Team
1. **Database**
   - Sau khi pull code mới, cần chạy:
     ```bash
     php artisan migrate:fresh
     php artisan db:seed --class=AdminSeeder
     php artisan db:seed --class=TestDataSeeder
     ```

2. **Authentication**
   - Hệ thống đăng nhập sử dụng email thay vì username
   - File cấu hình auth đã được cập nhật tương ứng

3. **Tạo Invoice**
   - Khi tạo invoice mới, cần lấy thông tin xe từ bảng `car_details`
   - Kiểm tra trạng thái xe trước khi tạo invoice

4. **Best Practices**
   - Luôn kiểm tra relationship trước khi truy cập để tránh lỗi null
   - Sử dụng eager loading khi cần truy vấn nhiều relationship để tối ưu hiệu năng
   - Đảm bảo cập nhật trạng thái xe sau khi tạo invoice

### Coming Soon
- [ ] Thêm tính năng xuất PDF cho invoice
- [ ] Tích hợp thanh toán online
- [ ] Thêm tính năng quản lý kho xe
- [ ] Dashboard thống kê doanh số theo tháng/quý 
