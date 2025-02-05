<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function UploadPayment(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'transaction_id' => 'required',
                'attachments' => 'required|image|mimes:jpeg,png,jpg'
            ]);

             if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $existing_data = TransactionPayment::where('transaction_id', $request->transaction_id)->exists();

            if($existing_data) {
                return response()->json(['errors' => 'Anda Sudah Melakukan Pembayaran'], 422);
            }

            if($request->hasFile('attachments')){
                $file = $request->file('attachments');
                $path = $file->store('proof', 'public');

                $result = TransactionPayment::create([
                    'transaction_id' => $request->transaction_id,
                    'status_payment' => 'Paid',
                    'attachments' => $path
                ]);

                Transaction::where('id', $request->transaction_id)->update([
                    'status' => 'Paid Payment'
                ]);

                return response()->json([
                    'message' => 'Payment Uploaded Successfully',
                    'data' => $result
                ], 201);
            }

             return response()->json(['message' => 'File upload failed.'], 500);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
}
