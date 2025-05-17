<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\CarDetail;
use App\Models\User;
use Faker\Factory as Faker;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy một saler để gán cho hóa đơn
        $saler = User::where('role', 'saler')->first();
        if (!$saler) {
            $saler = User::create([
                'name' => 'Test Saler',
                'email' => 'saler@example.com',
                'password' => bcrypt('password'),
                'role' => 'saler'
            ]);
        }

        // Lấy các car details có sẵn
        $carDetails = CarDetail::with(['car', 'carColor'])->get();

        if ($carDetails->isEmpty()) {
            $this->command->info('Không có car details. Vui lòng thêm car details trước.');
            return;
        }

        // Tạo 5 hóa đơn mẫu
        for ($i = 0; $i < 5; $i++) {
            $invoice = Invoice::create([
                'customer_name' => $faker->name,
                'customer_email' => $faker->email,
                'customer_phone' => $faker->numerify('##########'),
                'customer_address' => $faker->address,
                'purchase_date' => now(),
                'payment_method' => $faker->randomElement(['cash', 'bank_transfer', 'credit_card']),
                'status' => $faker->randomElement(['pending', 'recheck', 'done', 'cancel']),
                'saler_id' => $saler->id,
                'total_price' => 0
            ]);

            // Tạo 1-3 chi tiết hóa đơn cho mỗi hóa đơn
            $total_price = 0;
            $numDetails = rand(1, 3);

            for ($j = 0; $j < $numDetails; $j++) {
                $carDetail = $carDetails->random();
                $quantity = rand(1, 3);

                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'car_detail_id' => $carDetail->id,
                    'quantity' => $quantity,
                    'price' => $carDetail->price
                ]);

                $total_price += $carDetail->price * $quantity;
            }

            // Cập nhật tổng tiền
            $invoice->update(['total_price' => $total_price]);
        }

        $this->command->info('Đã tạo xong dữ liệu mẫu cho hóa đơn!');
    }
}
