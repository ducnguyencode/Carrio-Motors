<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,     // Create users including admin
            CarSeeder::class,            // Create cars and car details
            InvoicesTableSeeder::class,  // Create main invoices
            InvoiceTestSeeder::class,    // Create test invoices for search testing
        ]);
    }
}
