<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('medications', MedicationController::class);
    Route::delete('medications/{id}/force', [MedicationController::class, 'destroyPermanently'])
        ->name('medications.forceDelete');
    Route::post('medications/{id}/restore', [MedicationController::class, 'restore'])->name('medications.restore');    

    Route::apiResource('customers', CustomerController::class);
    Route::delete('customers/{id}/force', [CustomerController::class, 'destroyPermanently'])->name('customers.forceDelete');
    Route::post('customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
});
