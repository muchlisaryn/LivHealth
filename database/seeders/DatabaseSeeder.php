<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TransactionPayment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      
        $this->call([
            UserSeeder::class,
            BankNameSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            ProgramSeeder::class,
            TransactionSeeder::class,
            TransactionPaymentSeeder::class,
            ShippingCostSeeder::class,
            DeliveryStatusSeeder::class
        ]);
        
    }
}
