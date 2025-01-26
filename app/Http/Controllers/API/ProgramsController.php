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
            'message' => 'Get All Programs',
            'data' => $result
        ]);
    }

    public function show(Programs $programs) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Get detail Programs',
            'data' => $programs
        ]);
    }

    public function searchPrograms(Request $request) : JsonResponse
    {
        $search_term = $request->query('q');

        $request->validate([
            'q' => 'nullable|string|max:255'
        ]);

        $result = Programs::where('name', 'like', '%' . $search_term . '%')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get programs by name',
            'data' => $result
        ]);
    }

    public function getCount() : JsonResponse
    {
        $result = Programs::count();

        return response()->json([
            'success' => true,
            'message' => 'Get All Count Programs',
            'count' => $result
        ]);
    }
}
