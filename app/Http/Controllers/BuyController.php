<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarDetail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseConfirmation;
use App\Mail\AdminOrderNotification;

class BuyController extends Controller
{
    /**
     * Show the purchase form for a car
     */
    public function showPurchaseForm($carId)
    {
        $car = Car::with(['carDetails', 'carDetails.carColor', 'engine'])->findOrFail($carId);

        // Get the selected car detail if specified in the query params
        $selectedDetailId = request('detail_id');
        $selectedDetail = null;

        if ($selectedDetailId && $car->carDetails->contains('id', $selectedDetailId)) {
            $selectedDetail = $car->carDetails->firstWhere('id', $selectedDetailId);
        } elseif ($car->carDetails->count() > 0) {
            // Default to first car detail if none specified
            $selectedDetail = $car->carDetails->first();
        }

        return view('buy', compact('car', 'selectedDetail'));
    }

    /**
     * Process the purchase
     */
    public function processPurchase(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'car_detail_id' => 'required|exists:cars_details,id',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:bank_transfer,credit_card,cash',
        ]);

        // Get car and detail information
        $car = Car::findOrFail($request->car_id);
        $carDetail = CarDetail::findOrFail($request->car_detail_id);

        // Create order record in database (if Orders table exists)
        try {
            $order = Order::create([
                'customer_name' => $request->fullname,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'customer_address' => $request->address,
                'car_id' => $car->id,
                'car_detail_id' => $carDetail->id,
                'quantity' => $request->quantity,
                'total_price' => $carDetail->price * $request->quantity,
                'payment_method' => $request->payment_method,
                'additional_info' => $request->additional_info,
                'status' => 'pending',
            ]);
        } catch (\Exception $e) {
            // If Orders table doesn't exist, we'll just proceed without creating a record
            // and rely on the email notifications
            $order = null;
        }

        // Send email to customer
        $customerData = [
            'name' => $request->fullname,
            'email' => $request->email,
            'car' => $car->name,
            'color' => $carDetail->carColor->name ?? 'Standard',
            'price' => number_format($carDetail->price, 2),
            'quantity' => $request->quantity,
            'total' => number_format($carDetail->price * $request->quantity, 2),
            'payment_method' => $this->formatPaymentMethod($request->payment_method),
            'order_id' => $order ? $order->id : uniqid('ORD-'),
            'order_date' => now()->format('F j, Y'),
        ];

        try {
            Mail::to($request->email)
                ->send(new PurchaseConfirmation($customerData));

            // Send notification to admin
            Mail::to(config('mail.admin_address', 'admin@carrio-motors.com'))
                ->send(new AdminOrderNotification($customerData));
        } catch (\Exception $e) {
            // Log email sending error but don't stop the process
            \Log::error('Failed to send purchase emails: ' . $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Purchase completed successfully'
            ]);
        }

        // Use new success route
        return redirect()
            ->route('purchase.success')
            ->with('order', $customerData);
    }

    /**
     * Show purchase success page
     */
    public function showSuccessPage()
    {
        // Check if we have order data in the session
        if (session('order')) {
            return view('buy_success', ['order' => session('order')]);
        }

        // If no order data in session, create sample data for testing
        $sampleOrder = [
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'car' => 'Sample Car Model',
            'color' => 'Silver',
            'price' => '9,000.00',
            'quantity' => 1,
            'total' => '9,000.00',
            'payment_method' => 'Cash on Delivery',
            'order_id' => 'ORD-' . uniqid(),
            'order_date' => now()->format('F j, Y'),
        ];

        return view('buy_success', ['order' => $sampleOrder]);
    }

    /**
     * Format payment method for display
     */
    private function formatPaymentMethod($method)
    {
        $methods = [
            'bank_transfer' => 'Bank Transfer',
            'credit_card' => 'Credit Card / Debit Card',
            'cash' => 'Cash on Delivery',
        ];

        return $methods[$method] ?? $method;
    }
}
