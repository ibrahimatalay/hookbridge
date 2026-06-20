<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class EndpointController extends Controller
{
    public function index(Tenant $tenant)
    {
        return response()->json($tenant->endpoints);
    }
}
