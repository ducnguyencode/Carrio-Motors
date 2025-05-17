<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\User;
use App\Models\CarDetail;
use Faker\Factory as Faker;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get admin and saler users
        $admin = User::where('role', 'admin')->first();
        $saler = User::where('role', 'saler')->first();

        if (!$admin || !$saler) {
            return;
        }

        // Get available car details
        $carDetails = CarDetail::with(['car', 'carColor'])
            ->whereHas('car', function($query) {
                $query->where('status', true);
            })
            ->where('quantity', '>', 0)
            ->get();

        if ($carDetails->isEmpty()) {
            return;
        }

        // Create 10 sample invoices
        for ($i = 0; $i < 10; $i++) {
            $invoice = Invoice::create([
                'customer_name' => $faker->name,
                'customer_email' => $faker->email,
                'customer_phone' => $faker->numerify('0#########'), // Format: 0xxxxxxxxx
                'customer_address' => $faker->address,
                'purchase_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'payment_method' => $faker->randomElement(['cash', 'bank_transfer', 'credit_card']),
                'status' => $faker->randomElement(['pending', 'recheck', 'done', 'cancel']),
                'saler_id' => $saler->id,
                'isActive' => true
            ]);

            // Add 1-3 random cars to the invoice
            $selectedCarDetails = $carDetails->random(rand(1, 3));
            $total_price = 0;

            foreach ($selectedCarDetails as $carDetail) {
                $quantity = rand(1, min(3, $carDetail->quantity));
                $price = $carDetail->price;

                $invoice->invoiceDetails()->create([
                    'car_detail_id' => $carDetail->id,
                    'quantity' => $quantity,
                    'price' => $price
                ]);

                // Update car detail quantity
                $carDetail->quantity -= $quantity;
                $carDetail->save();

                $total_price += $price * $quantity;
            }

            // Update invoice total price
            $invoice->total_price = $total_price;
            $invoice->save();
        }
    }
}
