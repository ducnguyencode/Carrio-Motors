<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuccessController extends Controller
{
    /**
     * Display the purchase success page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Create sample order data for testing
        $sampleOrder = [
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'car' => 'Sample Car Model',
            'color' => 'Silver',
            'price' => '9,000.00',
            'quantity' => 1,
            'total' => '9,000.00',
            'payment_method' => 'Bank Transfer',
            'order_id' => 'ORD-' . uniqid(),
            'order_date' => now()->format('F j, Y'),
            'phone' => '123-456-7890'
        ];

        // Use session data if available, otherwise use sample data
        $orderData = session('order') ?? $sampleOrder;

        return view('buy_success', ['order' => $orderData]);
    }
}
