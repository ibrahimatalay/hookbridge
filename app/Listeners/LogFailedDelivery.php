<?php

namespace App\Listeners;

use App\Events\WebhookDeliveryFailed;
use Illuminate\Support\Facades\Log;

class LogFailedDelivery
{
    public function handle(WebhookDeliveryFailed $event): void
    {
        Log::warning('Webhook delivery failed', [
            'delivery_id' => $event->delivery->id,
            'endpoint_id' => $event->delivery->endpoint_id,
            'response_status' => $event->delivery->response_status,
        ]);
    }
}
