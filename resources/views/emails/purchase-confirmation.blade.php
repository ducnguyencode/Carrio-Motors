@component('mail::message')
# Xác nhận đơn hàng

Kính gửi {{ $order['name'] }},

Cảm ơn bạn đã đặt mua xe tại Carrio Motors. Dưới đây là thông tin đơn hàng của bạn:

**Mã đơn hàng:** {{ $order['order_id'] }}
**Ngày đặt hàng:** {{ $order['order_date'] }}

## Chi tiết đơn hàng

@component('mail::table')
| Xe | Màu sắc | Số lượng | Giá |
|:------------- |:------------- |:------------- |:------------- |
| {{ $order['car'] }} | {{ $order['color'] }} | {{ $order['quantity'] }} | ${{ $order['price'] }} |
@endcomponent

**Tổng cộng:** ${{ $order['total'] }}
**Phương thức thanh toán:** {{ $order['payment_method'] }}

## Các bước tiếp theo

Nhân viên của chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ để xác nhận đơn hàng và hướng dẫn bạn các bước tiếp theo.

@component('mail::button', ['url' => config('app.url')])
Xem xe khác
@endcomponent

Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc hotline: **0123-456-789**.

Trân trọng,<br>
{{ config('app.name') }}

<small>Đây là email tự động, vui lòng không trả lời email này.</small>
@endcomponent
