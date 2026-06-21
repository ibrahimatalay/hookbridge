<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Http\Requests\StoreEndpointRequest;
use App\Http\Resources\EndpointResource;

class EndpointController extends Controller
{
    public function index(Tenant $tenant)
    {
        return EndpointResource::collection($tenant->endpoints);
    }

    public function store(StoreEndpointRequest $request, Tenant $tenant)
    {
        $endpoint = $tenant->endpoints()->create($request->validated());

        return (new EndpointResource($endpoint))
            ->response()
            ->setStatusCode(201);
    }
}
