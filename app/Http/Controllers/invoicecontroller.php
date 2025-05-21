<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarDetail;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is admin or saler
        if (!Auth::user()->isAdmin() && !Auth::user()->isSaler()) {
            return redirect('/')->with('error', 'You do not have permission to access this page!');
        }

        $invoices = Invoice::with('user')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display the user's purchases
     */
    public function userPurchases()
    {
        $user = Auth::user();
        $invoices = Invoice::where('user_id', $user->id)
            ->with(['invoiceDetails.carDetail.car', 'invoiceDetails.carDetail.carColor'])
            ->latest()
            ->paginate(10);

        return view('invoices.user_purchases', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is admin or saler
        if (!Auth::user()->isAdmin() && !Auth::user()->isSaler()) {
            return redirect('/')->with('error', 'You do not have permission to access this page!');
        }

        return view('invoices.create');
    }

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
                'user_id' => Auth::id(),
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Check if user is admin, saler, or the owner of this invoice
        $invoice = Invoice::with('details.carDetail')->findOrFail($id);

        if (!Auth::user()->isAdmin() && !Auth::user()->isSaler() && Auth::id() !== $invoice->user_id) {
            return redirect('/')->with('error', 'You do not have permission to view this invoice!');
        }

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Check if user is admin or saler
        if (!Auth::user()->isAdmin() && !Auth::user()->isSaler()) {
            return redirect('/')->with('error', 'You do not have permission to access this page!');
        }

        $invoice = Invoice::with(['user', 'details.carDetail'])->findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if user is admin or saler
        if (!Auth::user()->isAdmin() && !Auth::user()->isSaler()) {
            return redirect('/')->with('error', 'You do not have permission to access this page!');
        }

        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'nullable|email|max:255',
            'buyer_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|in:cash,credit,installment',
            'process_status' => 'required|in:deposit,payment,warehouse,success,cancel',
        ]);

        $invoice = Invoice::findOrFail($id);

        // Cập nhật thông tin hóa đơn
        $invoice->buyer_name = $request->buyer_name;
        $invoice->buyer_email = $request->buyer_email;
        $invoice->buyer_phone = $request->buyer_phone;
        $invoice->payment_method = $request->payment_method;
        $invoice->process_status = $request->process_status;
        $invoice->save();

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Invoice updated successfully!');
    }

    /**
     * Update invoice status.
     */
    public function updateStatus(Request $request, $id)
    {
        // Check if user is admin or saler
        if (!Auth::user()->isAdmin() && !Auth::user()->isSaler()) {
            return redirect('/')->with('error', 'You do not have permission to access this page!');
        }

        $request->validate([
            'status' => 'required|in:deposit,payment,warehouse,success,cancel',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->process_status = $request->status;
        $invoice->save();

        return back()->with('success', 'Invoice status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'You do not have permission to delete invoices!');
        }

        // Không thực sự xóa, chỉ đánh dấu là đã hủy
        $invoice->process_status = 'cancel';
        $invoice->save();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice has been cancelled successfully');
    }
}
