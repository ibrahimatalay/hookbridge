<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Http\Requests\StoreEndpointRequest;
use App\Http\Resources\EndpointResource;
use App\Models\Endpoint;
use App\Http\Requests\UpdateEndpointRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EndpointController extends Controller
{
    public function index(Tenant $tenant): AnonymousResourceCollection
    {
        return EndpointResource::collection($tenant->endpoints);
    }

    public function store(StoreEndpointRequest $request, Tenant $tenant): JsonResponse
    {
        $endpoint = $tenant->endpoints()->create($request->validated());

        return (new EndpointResource($endpoint))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Tenant $tenant, Endpoint $endpoint): EndpointResource
    {
        return new EndpointResource($endpoint);
    }

    public function update(UpdateEndpointRequest $request, Tenant $tenant, Endpoint $endpoint): EndpointResource
    {
        $endpoint->update($request->validated());

        return new EndpointResource($endpoint);
    }

    public function destroy(Tenant $tenant, Endpoint $endpoint): Response
    {
        $endpoint->delete();

        return response()->noContent();
    }
}
