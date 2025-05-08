<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\CarDetail;

class BuyController extends Controller
{
    public function submit(Request $request) {
        $request->validate([
            'customer_name' => 'required',
            'car_detail_id' => 'required|exists:car_details,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required'
        ]);

        $carDetail = CarDetail::findOrFail($request->car_detail_id);
        $price = $carDetail->price * $request->quantity;

        $invoice = Invoice::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $price,
            'payment_method' => $request->payment_method,
        ]);

        InvoiceDetail::create([
            'invoice_id' => $invoice->id,
            'car_detail_id' => $carDetail->id,
            'quantity' => $request->quantity,
            'price' => $carDetail->price
        ]);

        return redirect('/')->with('success', 'Purchase submitted successfully!');
    }
}
