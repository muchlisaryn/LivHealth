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
        $bank = [['name' => 'BCA', 'no_rek' => 338876543], [ 'name' => 'BNI', 'no_rek' => 338834542], ['name' => 'BRI', 'no_rek' => 338834542], [ 'name' => 'BSI', 'no_rek' => 338834542], [ 'name' => 'MANDIRI', 'no_rek' => 338843342],[ 'name' => 'BANK DKI', 'no_rek' => 335574542] ];
        foreach($bank as $data) {
            BankName::create($data);
        }
    }
}
