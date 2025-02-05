<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BankName;
use App\Models\Programs;
use App\Models\ShippingCost;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //
    public function GetAllTransaction($user_id) : JsonResponse
    {
        try {
             $transaction = Transaction::where('user_id', $user_id)
             ->with('programs', 'payment')
             ->get();

             return response()->json([
                'success' => true,
                'message' => 'Get All Transaction',
                'data' => $transaction
             ]);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed Get All Transaction',
                'error' => $e->getMessage(), // Optional: include the actual error message
            ], 500);
        }
    }

    public function DetailsPaymentTransaction($id) : JsonResponse
    {
        try {
            $transactionPayment = TransactionPayment::where('transaction_id', $id)->exists();

            if($transactionPayment){
                return response()->json([
                'success' => false,
                'message' => 'Anda Sudah Melakukan Pembayaran',
                'reason' => ''
                 ]);
            }


            $transaction = Transaction::where('id', $id)
            ->with('programs')
            ->first();

            if(!$transaction){
                return response()->json([
                'success' => false,
                'message' => 'ransaction Not Found', 
                ], 404);
            }

            if($transaction['status'] === 'Canceled'){
                 return response()->json([
                'success' => false,
                'message' => 'Transaksi Telah Dibatalkan',
                'reason' => $transaction['canceled_reason']
                 ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail Transaction',
                'data' => $transaction
            ]);

        } catch (\Exception $e) {
             return response()->json([
                'success' => false,
                'message' => 'Checkout Failed',
                'error' => $e->getMessage(), // Optional: include the actual error message
            ], 500);
        }
    }

    public function ProcessCheckout(Request $request) : JsonResponse
    {
        try {
             $request->validate([
                'programs_id' => 'required|max:255',
                'user_id' => 'required|max:255'
            ]);

            $programs = Programs::find($request->programs_id);

            if(!$programs) {
                return response()->json([
                    'success' => false,
                    'message' => 'Programs not found'
                ], 404);
            }

            $user = User::find($request->user_id);

            if(!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

           

            $result = Transaction::create([
                'programs_id' => $request->programs_id,
                'user_id' => $request->user_id,
                'order_price' => $request->order_price,
                'shipping_price' => $request->shipping_price,
                'sub_total' => $request->sub_total,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Success Create Transaction',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout Failed',
                'error' => $e->getMessage(), // Optional: include the actual error message
            ], 500);
        }
    }

    public function ProgramsCheckout($id, $user_id) : JsonResponse
    {   

        $programs = Programs::find($id);

        $user = User::find($user_id);

        if(!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed: User Not Found',
            ], 404);
        }

        $shipment_cost = ShippingCost::find($user['city_id']);
        $cost = 9000;

        if(!$programs ) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed: Program is missing',
            ], 404);
        }

        if($shipment_cost) {
            $cost = $shipment_cost['price'];
        }

         $programs['shiping_cost'] = $programs['duration_days'] * $cost;
         $programs['start_programs'] = Carbon::today()->addDay();
         $programs['end_programs'] = Carbon::today()->addDay($programs['duration_days'] + 1);
         $programs['total'] = ($programs['duration_days'] * $cost) + $programs['price'];

         $bank = BankName::all()->first();

         return response()->json([
            'success' => true,
            'message' => 'Get detail programs',
            'data' => $programs,
            'bank' => $bank
        ]);

    }
}
