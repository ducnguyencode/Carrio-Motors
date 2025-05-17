<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\User;

class InvoiceTestSeeder extends Seeder
{
    public function run()
    {
        // Tạo một user saler để liên kết với invoice
        $saler = User::where('role', 'saler')->first();
        if (!$saler) {
            $saler = User::factory()->create(['role' => 'saler']);
        }

        // Tạo các invoice với tên tiếng Việt để test
        $testData = [
            [
                'customer_name' => 'Tuấn Nguyễn',
                'customer_phone' => '0901234567',
            ],
            [
                'customer_name' => 'Tuan Tran',
                'customer_phone' => '0901234568',
            ],
            [
                'customer_name' => 'Hà Phạm',
                'customer_phone' => '0901234569',
            ],
            [
                'customer_name' => 'Ha Le',
                'customer_phone' => '0901234570',
            ],
            [
                'customer_name' => 'Khải Nguyễn',
                'customer_phone' => '0901234571',
            ],
            [
                'customer_name' => 'Khai Tran',
                'customer_phone' => '0901234572',
            ],
        ];

        foreach ($testData as $data) {
            Invoice::create([
                'customer_name' => $data['customer_name'],
                'customer_email' => strtolower(str_replace(' ', '.', $data['customer_name'])) . '@example.com',
                'customer_phone' => $data['customer_phone'],
                'customer_address' => '123 Test Street',
                'purchase_date' => now(),
                'total_price' => 1000000,
                'payment_method' => 'cash',
                'status' => 'pending',
                'saler_id' => $saler->id
            ]);
        }
    }
}
