<?php

namespace Database\Seeders;

use App\Models\BankName;
use Illuminate\Database\Seeder;

class BankNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bank = ['bank_name' => 'BCA', 'name' => 'PT LIVE HEALTH' , 'no_rek' => 338876543];
        BankName::create($bank);
    }
}
