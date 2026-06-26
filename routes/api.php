<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/health', [HealthController::class, 'show']);
Route::post('/events', [EventController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::apiResource('tenants.endpoints', EndpointController::class)->scoped();
    Route::get('/reports/deliveries', [ReportController::class, 'deliveries']);
});
