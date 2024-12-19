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
        $bank = [['name' => 'BCA'], [ 'name' => 'BNI'], ['name' => 'BRI'], [ 'name' => 'BSI'], [ 'name' => 'MANDIRI'],[ 'name' => 'BANK DKI'] ];
        foreach($bank as $data) {
            BankName::create($data);
        }
    }
}
