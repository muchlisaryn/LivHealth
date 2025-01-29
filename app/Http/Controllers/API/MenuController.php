<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{

    public function index() : JsonResponse
    {
       try {
        $result = Menus::all()->map(function ($menu) {
            $categoryIds = $menu->category_id;

            if(!is_array($categoryIds)){
                $categoryIds = [];
            }

            $categories = Categories::whereIn('id', $categoryIds)->get();
            $menu->category = $categories;
            return $menu;
        });

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

    public function getCount() : JsonResponse
    {
        $result = Menus::count();

        return response()->json([
            'success' => true,
            'message' => 'Get count menu',
            'count' => $result
        ]);
    }
    /**
     * Display a listing of the resource.
     */
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
