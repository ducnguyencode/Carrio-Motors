@component('mail::message')
# Đơn hàng mới

Có một đơn hàng mới đã được tạo trên hệ thống.

**Mã đơn hàng:** {{ $order['order_id'] }}
**Ngày đặt hàng:** {{ $order['order_date'] }}

## Thông tin khách hàng

**Tên:** {{ $order['name'] }}
**Email:** {{ $order['email'] }}
**Điện thoại:** {{ $order['phone'] ?? 'Không có' }}

## Chi tiết đơn hàng

@component('mail::table')
| Xe | Màu sắc | Số lượng | Giá |
|:------------- |:------------- |:------------- |:------------- |
| {{ $order['car'] }} | {{ $order['color'] }} | {{ $order['quantity'] }} | ${{ $order['price'] }} |
@endcomponent

**Tổng cộng:** ${{ $order['total'] }}
**Phương thức thanh toán:** {{ $order['payment_method'] }}

@component('mail::button', ['url' => config('app.url') . '/admin/orders'])
Xem chi tiết đơn hàng
@endcomponent

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
