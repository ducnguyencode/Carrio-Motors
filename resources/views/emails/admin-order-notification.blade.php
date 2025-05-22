@component('mail::message')
# New Order

A new order has been created in the system.

**Order ID:** {{ $order['order_id'] }}
**Order Date:** {{ $order['order_date'] }}

## Customer Information

**Name:** {{ $order['name'] }}
**Email:** {{ $order['email'] }}
**Phone:** {{ $order['phone'] ?? 'Not provided' }}

## Order Details

@component('mail::table')
| Car | Color | Quantity | Price |
|:------------- |:------------- |:------------- |:------------- |
| {{ $order['car'] }} | {{ $order['color'] }} | {{ $order['quantity'] }} | ${{ $order['price'] }} |
@endcomponent

**Total:** ${{ $order['total'] }}
**Payment Method:** {{ $order['payment_method'] }}

@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin/orders'])
View Order Details
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
