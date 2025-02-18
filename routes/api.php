<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\MasterCityController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProgramsController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\WeeklyScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Detail logged in user',
        'data' => $request->user()
    ]);
});

Route::resource('master/city', MasterCityController::class)->only(['index']);

Route::resource('user', UsersController::class)->only('show', 'update');

Route::get('programs/count', [ProgramsController::class, 'getCount']);
Route::get('programs/search', [ProgramsController::class, 'searchPrograms']);
Route::resource('programs', ProgramsController::class)->only(['index', 'show']);

Route::post('upload_payment', [PaymentController::class, 'UploadPayment']);
Route::get('all-transaction/{user_id}', [CheckoutController::class, 'GetAllTransaction']);
Route::get('payment-transaction/{id}', [CheckoutController::class, 'DetailsPaymentTransaction']);
Route::post('checkout', [CheckoutController::class, 'ProcessCheckout']);
Route::get('programs_checkout/{id}/{user_id}', [CheckoutController::class, 'ProgramsCheckout']);

Route::get('order/{$transaction_id}', [OrderController::class, 'GetAllOrder']);

Route::get('categories/count', [CategoryController::class, 'getCount']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);


Route::get('menu/count', [MenuController::class, 'getCount']);
Route::resource('menu', MenuController::class)->only(['index', 'show']);

Route::resource('weekly-schedules', WeeklyScheduleController::class)->only(['index']);


require __DIR__ . '/auth.php';