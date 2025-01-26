<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\ProgramsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('programs', ProgramsController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index']);

Route::get('categories/count', [CategoryController::class, 'getCount']);
Route::get('menu/count', [MenuController::class, 'getCount']);
Route::get('programs/count', [ProgramsController::class, 'getCount']);
