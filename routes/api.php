<?php

use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\TenantApiController;
use App\Http\Controllers\Api\BillApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\LineWebhookController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/rooms', [RoomApiController::class, 'index']);
    Route::get('/tenants', [TenantApiController::class, 'index']);
    Route::get('/bills', [BillApiController::class, 'index']);
    Route::get('/payments', [PaymentApiController::class, 'index']);
});

Route::post('/line/webhook', [LineWebhookController::class, 'handle']);