<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    //
    public function GetAllOrder($transaction_id) : JsonResponse
    {
        try {
            
            $transaction = Transaction::find($transaction_id);


            if(!$transaction){
                 return response()->json([
                'success' => false,
                'message' => 'Failed Get All Order',
                'error' => 'Transaksi Tidak Ditemukan',
            ], 404);
            }

            $order = Order::where('transaction_id', $transaction_id)
            ->with('transaction')
            ->get();

            return response()->json([
                'success' => true,
                'message' => 'Get All Order Transaction',
                'data' => $order
            ]);

        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed Get All Order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
