<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/transaction/create', [TransactionController::class, 'store'])
     ->middleware('signature.verify');

Route::get('/transaction/confirm/{transaction_id}', [TransactionController::class, 'confirm']);

Route::get('/transaction/{transaction_id}/status', [TransactionController::class, 'show']);
