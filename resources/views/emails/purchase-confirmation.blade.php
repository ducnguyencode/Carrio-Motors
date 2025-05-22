@component('mail::message')
# Order Confirmation

Dear {{ $order['name'] }},

Thank you for your purchase at Carrio Motors. Below are the details of your order:

**Order ID:** {{ $order['order_id'] }}
**Order Date:** {{ $order['order_date'] }}

## Order Details

@component('mail::table')
| Car | Color | Quantity | Price |
|:------------- |:------------- |:------------- |:------------- |
| {{ $order['car'] }} | {{ $order['color'] }} | {{ $order['quantity'] }} | ${{ $order['price'] }} |
@endcomponent

**Total:** ${{ $order['total'] }}
**Payment Method:** {{ $order['payment_method'] }}

## Next Steps

Our staff will contact you within 24 hours to confirm your order and guide you through the next steps.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/cars'])
Browse More Cars
@endcomponent

If you have any questions, please contact us via email or call our hotline: **0123-456-789**.

Best regards,<br>
{{ config('app.name') }}

<small>This is an automated email. Please do not reply to this email.</small>
@endcomponent
