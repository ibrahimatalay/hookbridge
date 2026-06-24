<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\EventController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/health', [HealthController::class, 'show']);
Route::get('/tenants', [TenantController::class, 'index']);
Route::apiResource('tenants.endpoints', EndpointController::class)->scoped();
Route::post('/events', [EventController::class, 'store']);
