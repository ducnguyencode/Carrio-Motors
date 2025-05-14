<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\User;
use App\Models\CarDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\PDF;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with(['details.carDetail', 'customer', 'saler'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get statistics
        $statistics = [
            'total_invoices' => Invoice::count(),
            'total_revenue' => Invoice::where('status', 'completed')->sum('total_price'),
            'pending_invoices' => Invoice::whereIn('status', ['deposit', 'paid'])->count(),
            'cancelled_invoices' => Invoice::where('status', 'cancelled')->count()
        ];

        return view('admin.invoices.index', compact('invoices', 'statistics'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = User::where('role', 'customer')->get();
        $salers = User::where('role', 'saler')->get();
        $carDetails = CarDetail::with(['car', 'carColor'])->where('is_available', true)->get();

        return view('admin.invoices.create', compact('customers', 'salers', 'carDetails'));
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'saler_id' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,processing,completed,canceled',
            'payment_method' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'car_details' => 'required|array|min:1',
            'car_details.*.id' => 'required|exists:car_details,id',
            'car_details.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            // Calculate total amount and check inventory
            foreach ($validated['car_details'] as $item) {
                $carDetail = CarDetail::findOrFail($item['id']);

                if ($carDetail->quantity < $item['quantity']) {
                    return redirect()->back()->withInput()
                        ->with('error', 'Insufficient quantity for ' . $carDetail->car->name);
                }

                $totalAmount += $carDetail->price * $item['quantity'];
            }

            // Create invoice
            $invoice = new Invoice();
            $invoice->customer_id = $validated['customer_id'];
            $invoice->saler_id = $validated['saler_id'] ?? null;
            $invoice->status = $validated['status'];
            $invoice->payment_method = $validated['payment_method'];
            $invoice->shipping_address = $validated['shipping_address'];
            $invoice->notes = $validated['notes'] ?? null;
            $invoice->total_amount = $totalAmount;
            $invoice->save();

            // Create invoice details and update inventory
            foreach ($validated['car_details'] as $item) {
                $carDetail = CarDetail::findOrFail($item['id']);

                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $invoice->id;
                $invoiceDetail->car_detail_id = $carDetail->id;
                $invoiceDetail->quantity = $item['quantity'];
                $invoiceDetail->unit_price = $carDetail->price;
                $invoiceDetail->subtotal = $carDetail->price * $item['quantity'];
                $invoiceDetail->save();

                // Update inventory
                $carDetail->quantity -= $item['quantity'];
                $carDetail->save();
            }

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice has been created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        // Check access rights for saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->customer_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this invoice.');
        }

        $invoice->load(['customer', 'saler', 'details.carDetail.car', 'details.carDetail.carColor']);

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        // Check access rights for saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->customer_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this invoice.');
        }

        $customers = User::where('role', 'customer')->get();
        $salers = User::where('role', 'saler')->get();
        $invoice->load(['details.carDetail.car', 'details.carDetail.carColor']);

        return view('admin.invoices.edit', compact('invoice', 'customers', 'salers'));
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Check access rights for saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->customer_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this invoice.');
        }

        $validated = $request->validate([
            'saler_id' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,processing,completed,canceled',
            'payment_method' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // If it's a saler, only allow updating status and notes
        if (Auth::user()->role === 'saler') {
            $invoice->status = $validated['status'];
            $invoice->notes = $validated['notes'] ?? null;
        } else {
            // If it's an admin, allow updating all
            $invoice->saler_id = $validated['saler_id'] ?? null;
            $invoice->status = $validated['status'];
            $invoice->payment_method = $validated['payment_method'];
            $invoice->shipping_address = $validated['shipping_address'];
            $invoice->notes = $validated['notes'] ?? null;
        }

        $invoice->save();

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice has been updated successfully.');
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        // Only admin can delete invoices
        if (Auth::user()->role !== 'admin') {
            abort(403, 'You do not have permission to delete this invoice.');
        }

        // Cannot delete completed invoices
        if ($invoice->status === 'completed') {
            return redirect()->route('admin.invoices.index')
                ->with('error', 'Cannot delete completed invoices.');
        }

        DB::beginTransaction();

        try {
            // Return product quantities if the order was not cancelled
            if ($invoice->status !== 'canceled') {
                foreach ($invoice->invoiceDetails as $detail) {
                    $carDetail = $detail->carDetail;
                    $carDetail->quantity += $detail->quantity;
                    $carDetail->save();
                }
            }

            // Delete invoice details
            $invoice->invoiceDetails()->delete();

            // Delete invoice
            $invoice->delete();

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice has been deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.invoices.index')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Update the status of an invoice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Check access rights for saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->customer_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this invoice.');
        }

        $validated = $request->validate([
            'status' => 'required|in:deposit,paid,processing,completed,cancelled',
        ]);

        $invoice->status = $validated['status'];
        $invoice->save();

        return redirect()->back()
            ->with('success', 'Invoice status has been updated successfully.');
    }

    public function statistics(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $dailyRevenue = Invoice::where('status', 'completed')
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(purchase_date) as date'),
                DB::raw('COUNT(*) as total_invoices'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('SUM(discount_amount) as total_discount')
            )
            ->groupBy('date')
            ->get();

        $paymentMethodStats = Invoice::where('status', 'completed')
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->select('payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();

        return view('admin.invoices.statistics', compact('dailyRevenue', 'paymentMethodStats', 'startDate', 'endDate'));
    }

    public function approve(Invoice $invoice)
    {
        if ($invoice->status === 'deposit') {
            $invoice->status = 'payment';
            $invoice->save();

            // Log the approval
            activity()
                ->performedOn($invoice)
                ->causedBy(auth()->user())
                ->log('Invoice approved for payment');

            return redirect()->back()->with('success', 'Invoice approved for payment.');
        }

        return redirect()->back()->with('error', 'Invoice cannot be approved in its current state.');
    }

    public function reject(Invoice $invoice, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $invoice->status = 'cancel';
        $invoice->rejection_reason = $request->reason;
        $invoice->save();

        // Log the rejection
        activity()
                ->performedOn($invoice)
                ->causedBy(auth()->user())
                ->withProperties(['reason' => $request->reason])
                ->log('Invoice rejected');

        return redirect()->back()->with('success', 'Invoice has been rejected.');
    }

    public function exportReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $invoices = Invoice::with(['details.carDetail', 'user'])
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->get();

        // Generate PDF report
        $pdf = PDF::loadView('admin.invoices.report', compact('invoices', 'startDate', 'endDate'));

        return $pdf->download('invoice-report.pdf');
    }

    public function activityLog(Invoice $invoice)
    {
        $activities = $invoice->activities()->with('causer')->latest()->get();
        return view('admin.invoices.activity-log', compact('invoice', 'activities'));
    }

    public function manageDiscounts()
    {
        $invoicesWithDiscount = Invoice::whereNotNull('discount_type')
            ->with(['details.carDetail', 'user'])
            ->latest()
            ->paginate(15);

        $statistics = [
            'total_discount_amount' => Invoice::sum('discount_amount'),
            'percentage_discounts' => Invoice::where('discount_type', 'percentage')->count(),
            'fixed_discounts' => Invoice::where('discount_type', 'fixed')->count()
        ];

        return view('admin.invoices.discounts', compact('invoicesWithDiscount', 'statistics'));
    }

    public function updateDiscount(Invoice $invoice, Request $request)
    {
        $validated = $request->validate([
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'discount_reason' => 'required|string|max:255'
        ]);

        $invoice->update($validated);
        $invoice->calculateTotal();
        $invoice->save();

        activity()
            ->performedOn($invoice)
            ->causedBy(auth()->user())
            ->withProperties($validated)
            ->log('Discount updated');

        return redirect()->back()->with('success', 'Discount updated successfully.');
    }
}
