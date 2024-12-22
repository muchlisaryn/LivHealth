<?php

namespace Database\Seeders;

use App\Models\DeliveryStatus;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $delivery = [];
        $transactionIds = Transaction::pluck('id')->toArray();

        foreach($transactionIds as $transaction) {
            if(!empty($transactionIds)) {
                $delivery[] = [
                    'transaction_id' => $transaction,
                ];
            }
        }

        foreach($delivery as $data) {
            DeliveryStatus::create($data);
        }
    }
}
