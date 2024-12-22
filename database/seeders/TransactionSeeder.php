<?php

namespace Database\Seeders;

use App\Models\Programs;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $transactions = [];

        $count = 10;

        for($i = 0; $i < $count; $i++){
            $transactions[] = [
                'programs_id' => Programs::inRandomOrder()->value('id'),
                'user_id' => User::inRandomOrder()->value('id'),
                'total_price' => rand(40000, 99999999),
            ];
        }
 
        foreach($transactions as $transaction) {
            Transaction::create($transaction);
        }    
    }
}
