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

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['user', 'saler', 'invoiceDetails.carDetail.car', 'invoiceDetails.carDetail.carColor']);

        // Nếu là Saler, chỉ hiển thị các đơn hàng được gán hoặc của khách hàng quản lý
        if (Auth::user()->role === 'saler') {
            $query->where(function($q) {
                $q->where('saler_id', Auth::id())
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('saler_id', Auth::id());
                  });
            });
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Lọc theo thời gian
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);

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
        $carDetails = CarDetail::with(['car', 'carColor'])->where('is_available', true)->get();

        return view('admin.invoices.create', compact('users', 'salers', 'carDetails'));
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
            'user_id' => 'required|exists:users,id',
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

            // Tính tổng tiền và kiểm tra tồn kho
            foreach ($validated['car_details'] as $item) {
                $carDetail = CarDetail::findOrFail($item['id']);

                if ($carDetail->quantity < $item['quantity']) {
                    return redirect()->back()->withInput()
                        ->with('error', 'Số lượng xe ' . $carDetail->car->name . ' không đủ.');
                }

                $totalAmount += $carDetail->price * $item['quantity'];
            }

            // Tạo hóa đơn
            $invoice = new Invoice();
            $invoice->user_id = $validated['user_id'];
            $invoice->saler_id = $validated['saler_id'] ?? null;
            $invoice->status = $validated['status'];
            $invoice->payment_method = $validated['payment_method'];
            $invoice->shipping_address = $validated['shipping_address'];
            $invoice->notes = $validated['notes'] ?? null;
            $invoice->total_amount = $totalAmount;
            $invoice->save();

            // Tạo chi tiết hóa đơn và cập nhật tồn kho
            foreach ($validated['car_details'] as $item) {
                $carDetail = CarDetail::findOrFail($item['id']);

                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $invoice->id;
                $invoiceDetail->car_detail_id = $carDetail->id;
                $invoiceDetail->quantity = $item['quantity'];
                $invoiceDetail->unit_price = $carDetail->price;
                $invoiceDetail->subtotal = $carDetail->price * $item['quantity'];
                $invoiceDetail->save();

                // Cập nhật tồn kho
                $carDetail->quantity -= $item['quantity'];
                $carDetail->save();
            }

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Đơn hàng đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()
                ->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
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
        // Kiểm tra quyền truy cập nếu là saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403, 'Không có quyền truy cập đơn hàng này.');
        }

        $invoice->load(['user', 'saler', 'invoiceDetails.carDetail.car', 'invoiceDetails.carDetail.carColor']);

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
        // Kiểm tra quyền truy cập nếu là saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403, 'Không có quyền truy cập đơn hàng này.');
        }

        $users = User::where('role', 'user')->get();
        $salers = User::where('role', 'saler')->get();
        $invoice->load(['invoiceDetails.carDetail.car', 'invoiceDetails.carDetail.carColor']);

        return view('admin.invoices.edit', compact('invoice', 'users', 'salers'));
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
        // Kiểm tra quyền truy cập nếu là saler
        if (Auth::user()->role === 'saler' && $invoice->saler_id !== Auth::id() && $invoice->user->saler_id !== Auth::id()) {
            abort(403, 'Không có quyền truy cập đơn hàng này.');
        }

        $validated = $request->validate([
            'saler_id' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,processing,completed,canceled',
            'payment_method' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Nếu là saler, chỉ cho phép cập nhật trạng thái và ghi chú
        if (Auth::user()->role === 'saler') {
            $invoice->status = $validated['status'];
            $invoice->notes = $validated['notes'] ?? null;
        } else {
            // Nếu là admin, cho phép cập nhật tất cả
            $invoice->saler_id = $validated['saler_id'] ?? null;
            $invoice->status = $validated['status'];
            $invoice->payment_method = $validated['payment_method'];
            $invoice->shipping_address = $validated['shipping_address'];
            $invoice->notes = $validated['notes'] ?? null;
        }

        $invoice->save();

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', 'Đơn hàng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        // Chỉ admin mới có thể xóa đơn hàng
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Không có quyền xóa đơn hàng.');
        }

        // Nếu đơn hàng đã hoàn thành, không cho phép xóa
        if ($invoice->status === 'completed') {
            return redirect()->route('admin.invoices.index')
                ->with('error', 'Không thể xóa đơn hàng đã hoàn thành.');
        }

        DB::beginTransaction();

        try {
            // Hoàn trả số lượng sản phẩm nếu đơn hàng chưa bị hủy
            if ($invoice->status !== 'canceled') {
                foreach ($invoice->invoiceDetails as $detail) {
                    $carDetail = $detail->carDetail;
                    $carDetail->quantity += $detail->quantity;
                    $carDetail->save();
                }
            }

            // Xóa chi tiết đơn hàng
            $invoice->invoiceDetails()->delete();

            // Xóa đơn hàng
            $invoice->delete();

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Đơn hàng đã được xóa thành công.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.invoices.index')
                ->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
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
