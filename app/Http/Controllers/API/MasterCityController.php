<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShippingCost;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Log;

class MasterCityController extends Controller
{
   public function index() : JsonResponse
   {
     try {
        $result = ShippingCost::all();

        return response()->json([
            'success' => true,
            'message' => 'Get all menu',
            'data' => $result
        ]);
    } catch (\Exception $e) {
        Log::error('Error occurred: ' . $e->getMessage());

        // Return a custom response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'error' => $e->getMessage(), // Optional: include the actual error message
        ], 500); // 500 = Internal Server Error
    }
   }
}
