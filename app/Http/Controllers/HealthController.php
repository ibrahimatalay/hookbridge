<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

//use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'service' => 'HookBridge',
            'status'  => 'ok',
            'time'    => now()->toIso8601String(),
        ]);
    }
}
