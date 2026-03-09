<?php

use App\Http\Controllers\CashoutController;
use App\Http\Controllers\DepositController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/payments/payhero/callback', [DepositController::class, 'handle'])->name('callback.payhero');
Route::post('/cashouts/payhero/callback', [CashoutController::class, 'handle'])->name('callback.payhero');
