<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CarDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        $admin = User::create([
            'username' => 'admin',
            'fullname' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true
        ]);

        $saler = User::create([
            'username' => 'saler',
            'fullname' => 'Sales Person',
            'email' => 'saler@example.com',
            'password' => bcrypt('password'),
            'role' => 'saler',
            'is_active' => true
        ]);

        $customer = User::create([
            'username' => 'customer',
            'fullname' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_active' => true
        ]);

        // Create test invoice
        $invoice = Invoice::create([
            'buyer_name' => 'John Doe',
            'buyer_email' => 'john@example.com',
            'buyer_phone' => '1234567890',
            'purchase_date' => now(),
            'payment_method' => 'cash',
            'process_status' => 'deposit',
            'user_id' => $customer->id,
            'discount_type' => 'percentage',
            'discount_amount' => 10,
            'discount_reason' => 'New customer discount'
        ]);

        // Create test invoice details
        InvoiceDetail::create([
            'invoice_id' => $invoice->id,
            'car_detail_id' => 1, // Assuming you have car details
            'quantity' => 1,
            'price' => 50000
        ]);

        $invoice->calculateTotal();
        $invoice->save();
    }
}
