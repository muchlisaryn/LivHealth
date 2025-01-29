<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use App\Models\WeeklySchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeeklyScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()  : JsonResponse
    {
       try {
            $datas = WeeklySchedule::with(['category'])->get();

            $result = [];

            foreach ($datas as $data) {
                $menus = array_map('intval', $data->menu_id);
                $get_relation_in_menu = Menus::whereIn('id' , $menus)->get();

                $category = $data->category->name;
                $menu = $get_relation_in_menu->pluck('name');
                $result[] = [
                    'category' => $category,
                    'menu' => $menu
                ];
               
            }

           return response()->json([
                'success' => true,
                'message' => 'Get all Schedules',
                'data' => $result
            ]);
       }catch (\Exception $e) {
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
