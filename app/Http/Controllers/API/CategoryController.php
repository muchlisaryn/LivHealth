<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   
    public function getCount() : JsonResponse
    {
        $count = Categories::count();

        return response()->json([
            'success' => true,
            'message' => 'Get Cout Category',
            'count' => $count
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        //
        $result = [];


        $categories = Categories::all()->take(8);

       
        foreach($categories as $category) {
            $category['count'] = Menus::whereJsonContains('category_id', (string)$category->id)->count();
            $result[] = $category;
        }
       
        return response()->json([
            'success' => true,
            'message' => 'Get All Category',
            'data' => $result
        ]);
    }

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
