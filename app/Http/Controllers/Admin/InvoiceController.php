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
use Illuminate\Support\Facades\Log;
use App\Models\Car;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Invoice::query();

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        // Add eager loading for better performance
        $query->with(['user', 'saler']);

        // Add role-based filtering
        if (Auth::user()->role === 'saler') {
            $query->where(function($q) {
                $q->where('saler_id', Auth::id())
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('saler_id', Auth::id());
                  });
            });
        }

        $invoices = $query->latest()->paginate(10);

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $salers = User::where('role', 'saler')->get();

        // Thay đổi cách lấy dữ liệu car details
        $carDetails = DB::table('cars_details')
            ->join('cars', 'cars_details.car_id', '=', 'cars.id')
            ->join('models', 'cars.model_id', '=', 'models.id')
            ->join('engines', 'cars.engine_id', '=', 'engines.id')
            ->join('car_colors', 'cars_details.color_id', '=', 'car_colors.id')
            ->where('cars.status', true)
            ->where('cars_details.quantity', '>', 0)
            ->select(
                'cars_details.*',
                'cars.name as car_name',
                'models.name as model_name',
                'engines.name as engine_name',
                'car_colors.name as color_name'
            )
            ->get();

        $statuses = Invoice::getStatuses();

        return view('admin.invoices.create', compact('users', 'salers', 'carDetails', 'statuses'));
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'customer_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card',
            'car_detail_ids' => 'required|array',
            'car_detail_ids.*' => 'required|exists:cars_details,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Create invoice
            $invoice = new Invoice();
            $invoice->customer_name = $request->customer_name;
            $invoice->customer_email = $request->customer_email;
            $invoice->customer_phone = $request->customer_phone;
            $invoice->customer_address = $request->customer_address;
            $invoice->payment_method = $request->payment_method;
            $invoice->status = 'pending'; // Set initial status to pending
            $invoice->saler_id = Auth::id();
            $invoice->purchase_date = now();
            $invoice->save();

            $total_price = 0;

            // Create invoice details
            foreach ($request->car_detail_ids as $index => $carDetailId) {
                $quantity = $request->quantities[$index];

                // Get car detail with available stock
                $carDetail = CarDetail::where('id', $carDetailId)
                    ->where('quantity', '>=', $quantity)
                    ->first();

                if (!$carDetail) {
                    throw new \Exception('Selected car is not available in the requested quantity.');
                }

                // Create invoice detail
                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $invoice->id;
                $invoiceDetail->car_detail_id = $carDetail->id;
                $invoiceDetail->quantity = $quantity;
                $invoiceDetail->price = $carDetail->price;
                $invoiceDetail->save();

                // Update car detail quantity
                $carDetail->quantity -= $quantity;
                $carDetail->save();

                $total_price += $carDetail->price * $quantity;
            }

            // Update invoice total price
            $invoice->total_price = $total_price;
            $invoice->save();

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);

        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load(['user', 'saler', 'invoiceDetails.carDetail.car', 'invoiceDetails.carDetail.carColor']);

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);

        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403);
        }

        $users = User::where('role', 'user')->get();
        $salers = User::where('role', 'saler')->get();
        $invoice->load(['invoiceDetails.carDetail.car', 'invoiceDetails.carDetail.carColor']);
        $statuses = Invoice::getStatuses();

        return view('admin.invoices.edit', compact('invoice', 'users', 'salers', 'statuses'));
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);

        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403);
        }

        // Get valid statuses from model
        $validStatuses = [
            Invoice::STATUS_PENDING,
            Invoice::STATUS_RECHECK,
            Invoice::STATUS_DONE,
            Invoice::STATUS_CANCEL
        ];

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'customer_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card',
            'status' => 'required|in:' . implode(',', $validStatuses)
        ]);

        try {
            DB::beginTransaction();

            // Save old status for comparison
            $oldStatus = $invoice->status;

            // Update basic invoice information
            $invoice->fill([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'payment_method' => $request->payment_method,
                'status' => strtolower($request->status)
            ]);

            // Save changes
            $invoice->save();

            // If invoice details are being updated
            if ($request->has('invoice_details')) {
                foreach ($request->invoice_details as $detail) {
                    $invoiceDetail = InvoiceDetail::findOrFail($detail['id']);

                    if ($invoiceDetail->quantity != $detail['quantity']) {
                        $carDetail = $invoiceDetail->carDetail;
                        $carDetail->quantity += $invoiceDetail->quantity;
                        $carDetail->quantity -= $detail['quantity'];
                        $carDetail->save();

                        $invoiceDetail->quantity = $detail['quantity'];
                        $invoiceDetail->save();
                    }
                }

                // Recalculate total price
                $total_price = 0;
                foreach ($invoice->invoiceDetails as $detail) {
                    $total_price += $detail->price * $detail->quantity;
                }
                $invoice->total_price = $total_price;
                $invoice->save();
            }

            DB::commit();

            // Check if status was changed
            if ($oldStatus !== $invoice->fresh()->status) {
                $message = 'Invoice updated successfully. Status changed from ' . ucfirst($oldStatus) . ' to ' . ucfirst($invoice->status);
            } else {
                $message = 'Invoice updated successfully.';
            }

            return redirect()->route('admin.invoices.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Invoice update error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()
                ->withInput()
                ->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        try {
            // Check if user is saler and has permission to delete this invoice
            if (Auth::user()->role === 'saler') {
                if ($invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
                    return back()->with('error', 'You do not have permission to delete this invoice.');
                }
            }

            DB::beginTransaction();

            // Soft delete the invoice
            $invoice->delete();

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice has been moved to trash.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of trashed invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        // Ensure only admin can access trash
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.invoices.index')
                ->with('error', 'Only administrators can access the trash.');
        }

        $trashedInvoices = Invoice::onlyTrashed()->paginate(10);
        return view('admin.invoices.trash', compact('trashedInvoices'));
    }

    /**
     * Restore a soft-deleted invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // Ensure only admin can restore
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.invoices.index')
                ->with('error', 'Only administrators can restore invoices.');
        }

        try {
            $invoice = Invoice::onlyTrashed()->findOrFail($id);
            $invoice->restore();

            // Redirect về trang trash thay vì index
            return redirect()->route('admin.invoices.trash')
                ->with('success', 'Invoice has been restored successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error restoring invoice: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a soft-deleted invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        // Ensure only admin can force delete
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.invoices.index')
                ->with('error', 'Only administrators can permanently delete invoices.');
        }

        try {
            DB::beginTransaction();

            $invoice = Invoice::onlyTrashed()->findOrFail($id);

            // Delete related invoice details
            $invoice->invoiceDetails()->delete();

            // Permanently delete the invoice
            $invoice->forceDelete();

            DB::commit();

            return redirect()->route('admin.invoices.trash')
                ->with('success', 'Invoice has been permanently deleted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error permanently deleting invoice: ' . $e->getMessage());
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

        // Kiểm tra quyền truy cập nếu là saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403, 'Không có quyền truy cập đơn hàng này.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        $invoice->status = $validated['status'];
        $invoice->save();

        return redirect()->back()
            ->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
    }
}
