<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Programs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $result = Programs::all();

        return response()->json([
            'success' => true,
            'message' => 'Get all programs',
            'data' => $result
        ]);
    }

    public function getCount() : JsonResponse
    {
        $result = Programs::count();

        return response()->json([
            'success' => true,
            'message' => 'Get count programs',
            'count' => $result
        ]);
    }

    public function show($id) : JsonResponse
    {
        $result = Programs::find($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail programs',
            'data' => $result
        ]);
    }

    public function searchPrograms(Request $request) : JsonResponse
    {
        $search_term = $request->query('q');

        $validate =  $request->validate([
            'q' => 'nullable|string|max:255'
        ]);

       if($validate['q'] ?? null) { 
            $result_with_search = Programs::where('name', 'like', '%' . $search_term . '%')
            ->get();

             return response()->json([
                'success' => true,
                'message' => 'Get programs by name',
                'count' => $result_with_search->count(),
                'data' => $result_with_search
             ]);
             
       }else {
             $result = Programs::all();

            return response()->json([
                'success' => true,
                'message' => 'Get all programs',
                'count' => $result->count(),
                'data' => $result
            ]);
       }
    }

   
}
