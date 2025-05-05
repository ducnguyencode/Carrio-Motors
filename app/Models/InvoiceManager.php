<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\CarDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceManager
{
    public function createInvoice(array $customerInfo, array $carItemsData)
    {
        if (empty($carItemsData) || empty($customerInfo['customer_name']) || empty($customerInfo['customer_phone'])) {
            return false;
        }

        $totalPrice = 0;
        $invoiceDetailsData = [];

        DB::beginTransaction();

        try {
            foreach ($carItemsData as $item) {
                 if (!isset($item['car_detail_id']) ||
                     !is_numeric($item['car_detail_id']) || $item['car_detail_id'] <= 0 ||
                     !isset($item['quantity']) || !is_numeric($item['quantity']) || $item['quantity'] <= 0) {
                      DB::rollBack();
                      return false;
                 }

                $carDetail = CarDetail::find($item['car_detail_id']);

                if (!$carDetail || $carDetail->quantity < $item['quantity'] || !$carDetail->isActive) {
                    DB::rollBack();
                    return false;
                }

                $priceAtSale = $carDetail->price;
                $totalPrice += ($item['quantity'] * $priceAtSale);

                $invoiceDetailsData[] = [
                    'car_detail_id' => $item['car_detail_id'],
                    'quantity' => $item['quantity'],
                    'price' => $priceAtSale,
                    'isActive' => true,
                     'created_at' => Carbon::now(),
                     'updated_at' => Carbon::now(),
                ];
            }

            $invoice = Invoice::create([
                'customer_name' => $customerInfo['customer_name'],
                'customer_phone' => $customerInfo['customer_phone'],
                'customer_email' => $customerInfo['customer_email'] ?? null,
                'purchase_date' => Carbon::now(),
                'total_price' => $totalPrice,
                'payment_method' => $customerInfo['payment_method'] ?? 'Unspecified',
                'process' => 'đặt cọc',
                'isActive' => true,
            ]);

            foreach ($invoiceDetailsData as $detailData) {
                 $invoice->details()->create($detailData);
            }

            DB::commit();
            return $invoice->id;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateInvoiceStatus(int $invoiceId, string $newStatus): bool
    {
        $validStatuses = ['đặt cọc', 'thanh toán', 'xử lý kho', 'thành công', 'huỷ'];
        if (!in_array($newStatus, $validStatuses) || $invoiceId <= 0) {
            return false;
        }

        $invoice = Invoice::where('id', $invoiceId)->where('isActive', true)->first();

        if (!$invoice) {
            return false;
        }

        DB::beginTransaction();
        try {
            $invoice->process = $newStatus;
            $invoice->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getInvoiceById(int $invoiceId): ?Invoice
    {
         if ($invoiceId <= 0) {
             return null;
         }

        $invoice = Invoice::where('id', $invoiceId)->where('isActive', true)->with('details.carDetail.car')->first();

        return $invoice;
    }

    public function listAllInvoices()
    {
        return Invoice::where('isActive', true)->orderByDesc('purchase_date')->get();
    }

    public function softDeleteInvoice(int $invoiceId): bool
    {
        if ($invoiceId <= 0) {
            return false;
        }

        $invoice = Invoice::where('id', $invoiceId)->where('isActive', true)->first();

        if (!$invoice) {
            return false;
        }

        DB::beginTransaction();
        try {
            $invoice->isActive = false;
            $invoice->save();

            $invoice->details()->update(['isActive' => false]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
