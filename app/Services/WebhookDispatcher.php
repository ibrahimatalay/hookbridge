<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Event;
use Illuminate\Support\Facades\Http;
use App\Enums\DeliveryStatus;

class WebhookDispatcher
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function dispatch(Event $event): void
    {
        $endpoints = $event->eventType->endpoints;
        foreach ($endpoints as $endpoint) {
            $delivery = Delivery::create([
                'event_id' => $event->id,
                'endpoint_id' => $endpoint->id
            ]);
            $this->send($delivery);
        }
    }

    private function send(Delivery $delivery): void
    {
        try {
            $response = Http::timeout(5)->post(
                $delivery->endpoint->url,
                $delivery->event->payload
            );

            $delivery->update([
                'status' => $response->successful() ? DeliveryStatus::Success : DeliveryStatus::Failed,
                'attempts' => $delivery->attempts + 1,
                'response_status' => $response->status(),
                'delivered_at' => now(),
            ]);
        } catch (\Exception $e) {
            $delivery->update([
                'status' => DeliveryStatus::Failed,
                'attempts' => $delivery->attempts + 1,
            ]);
        }
    }
}
