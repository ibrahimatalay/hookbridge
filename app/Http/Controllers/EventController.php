<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Services\WebhookDispatcher;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function store(StoreEventRequest $request, WebhookDispatcher $dispatcher): JsonResponse
    {
        $data = $request->validated();
        $data['occurred_at'] = now();

        $event = Event::create($data);

        $dispatcher->dispatch($event);

        return response()->json([
            'event_id' => $event->id,
            'deliveries' => $event->deliveries()->count(),
        ], 201);
    }
}
