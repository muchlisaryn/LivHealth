<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menus;
use App\Models\Programs;
use App\Models\WeeklySchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $result = Programs::with('category')->get();
        

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
        try {
            $result = Programs::where('id', $id)
            ->with('category')
            ->first();

            $result['shiping_cost'] = $result['duration_days'] * 9000;
            
            $get_data_menus = WeeklySchedule::where('category_id', $result['category_id'])->first();

            if($get_data_menus || !empty($get_data_menus->menu_id)) {
                $menus_today =  Menus::whereIn('id', $get_data_menus->menu_id)->get()->map(function($menu) {
                $categoryIds = $menu->category_id;

                    if(!is_array($categoryIds)){
                        $categoryIds = [];
                    }

                    $categories = Categories::whereIn('id', $categoryIds)->get();
                    $menu->category = $categories;
                    return $menu;
                });

                $result['menu_today'] = $menus_today;
            }else {
                $result['menu_today'] = array();
            }

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
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed Get Order',
                'error' => $e->getMessage(),
            ], 500);
        }

        
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
