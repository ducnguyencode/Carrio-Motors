<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarDetail;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'nullable|email|max:255',
            'buyer_phone' => 'nullable|string|max:50',
            'items' => 'required|array',
            'items.*.car_detail_id' => 'required|exists:car_details,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,credit,installment',
        ]);

        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'buyer_name' => $request->buyer_name,
                'buyer_email' => $request->buyer_email,
                'buyer_phone' => $request->buyer_phone,
                'purchase_date' => now(),
                'payment_method' => $request->payment_method,
                'process_status' => 'deposit',
                'total_price' => 0,
            ]);

            $totalPrice = 0;

            foreach ($request->items as $item) {
                $carDetail = CarDetail::findOrFail($item['car_detail_id']);
                $itemPrice = $carDetail->price;

                $invoiceDetail = $invoice->details()->create([
                    'car_detail_id' => $item['car_detail_id'],
                    'quantity' => $item['quantity'],
                    'price' => $itemPrice,
                ]);

                $totalPrice += $itemPrice * $item['quantity'];
            }

            $invoice->total_price = $totalPrice;
            $invoice->save();

            DB::commit();

            return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors('An error occurred while creating the invoice: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $invoice = Invoice::with('details.carDetail')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function updateStatus($id, Request $request)
    {
         $request->validate([
            'status' => 'required|in:deposit,payment,warehouse,success,cancel',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->process_status = $request->status;
        $invoice->save();

        return back()->with('success', 'Invoice status updated successfully.');
    }
}
