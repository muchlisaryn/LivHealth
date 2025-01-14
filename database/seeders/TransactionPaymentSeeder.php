<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionPayment;
use Illuminate\Database\Seeder;

class TransactionPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionsPayment = [];
        
        $transactionIds = Transaction::pluck('id')->toArray();

        $status = ['Pending',  'Paid' , 'Rejected' , 'Verified'];

        foreach($transactionIds as $transaction) {
            if(!empty($transactionIds)) {
                $transactionsPayment[] = [
                    'transaction_id' => $transaction,
                    'status_payment' => 'paid'
                ];
            }
        }

    

        foreach($transactionsPayment as $payment) {
            TransactionPayment::create($payment);
        }
    }
}
