<?php

use App\Http\Controllers\ActiveProgramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//api
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('playground')->group(function () {
    Route::get('get-va', [App\Http\Controllers\PaymentController::class, 'getListVA']);
    Route::post('create-va', [App\Http\Controllers\PaymentController::class, 'createVA']);
    Route::get('get-invoice', [App\Http\Controllers\PaymentController::class, 'getAllInvoice']);
});
