<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WeeklySchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeeklyScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()  : JsonResponse
    {
        $result = WeeklySchedule::with(['menu', 'category'])->get();

       $result->transform(function($schedule) {
            $schedule->category->name;
            return $schedule;
       });

        return response()->json([
            'success' => true,
            'message' => 'Get all Schedules',
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
