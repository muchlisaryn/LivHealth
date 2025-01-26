<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\ProgramsController;
use App\Http\Controllers\API\WeeklyScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('programs/count', [ProgramsController::class, 'getCount']);
Route::get('programs/search', [ProgramsController::class, 'searchPrograms']);
Route::resource('programs', ProgramsController::class)->only(['index', 'show']);


Route::get('categories/count', [CategoryController::class, 'getCount']);
Route::resource('categories', CategoryController::class)->only(['index']);

Route::get('menu/count', [MenuController::class, 'getCount']);

Route::resource('weekly-schedules', WeeklyScheduleController::class)->only(['index']);

