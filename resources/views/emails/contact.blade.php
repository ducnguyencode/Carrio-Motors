<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #0d6efd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
    </div>

    <div class="content">
        <p>You have received a new contact form submission from your website. Details are below:</p>

        <div class="field">
            <div class="field-label">Name:</div>
            <div>{{ $name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div><a href="mailto:{{ $email }}">{{ $email }}</a></div>
        </div>

        <div class="field">
            <div class="field-label">Phone:</div>
            <div>{{ $phone }}</div>
        </div>

        <div class="field">
            <div class="field-label">Subject:</div>
            <div>{{ $subject }}</div>
        </div>

        @if(isset($is_purchase) && $is_purchase)
        <div class="field" style="margin-top: 20px; margin-bottom: 20px; background-color: #f0f8ff; padding: 15px; border-radius: 5px; border-left: 3px solid #0d6efd;">
            <div class="field-label" style="font-size: 16px; margin-bottom: 10px;">Purchase Information:</div>
            <div style="display: grid; grid-template-columns: 120px 1fr; gap: 8px; margin-left: 10px;">
                <div style="font-weight: bold;">Car Model:</div>
                <div>{{ $car }}</div>

                <div style="font-weight: bold;">Quantity:</div>
                <div>{{ $quantity }}</div>

                <div style="font-weight: bold;">Payment Method:</div>
                <div>{{ $payment_method }}</div>
            </div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="message-content">{{ $userMessage }}</div>
        </div>

        <p>Please respond to this inquiry as soon as possible.</p>
    </div>

    <div class="footer">
        <p>This email was sent from the contact form on the Carrio Motors website.</p>
        <p>&copy; {{ date('Y') }} Carrio Motors. All rights reserved.</p>
    </div>
</body>
</html>
