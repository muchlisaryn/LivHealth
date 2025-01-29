<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

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
    public function getCategoriesInLandingPage() : JsonResponse
    {
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

    public function index() : JsonResponse
    {
        //
        $result = [];


        $categories = Categories::all();

       
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
    public function show( $id) :JsonResponse
    {
      try {
        $get_data = Categories::where('id', $id)->get();

        $result = [];

        foreach($get_data as $data) {
            $menus = Menus::whereJsonContains('category_id', (string)$data->id)->get();
        
            $data['menu'] = $menus->isEmpty() ? [] : $menus->map(function($menu) {
                $categoryIds = $menu->category_id;

                if(!is_array($categoryIds)){
                    $categoryIds = [];
                }

                $categories = Categories::whereIn('id', $categoryIds)->get();
                $menu->category = $categories;
                return $menu;
            });
            
            $result[] = $data;
        }

        return response()->json([
            'success' => true,
            'message' => 'Get details Category',
            'data' => $get_data[0]
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
