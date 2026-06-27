<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Endpoint;
use App\Models\EventType;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use App\Events\WebhookDeliveryFailed;

class EventDispatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_posting_an_event_fans_out_to_subscribed_endpoints(): void
    {
        Http::fake();

        $tenant = Tenant::factory()->create();
        $eventType = EventType::factory()->create(['tenant_id' => $tenant->id]);
        $endpoint = Endpoint::factory()->create([
            'tenant_id' => $tenant->id,
            'is_active' => true,
        ]);
        $eventType->endpoints()->attach($endpoint);

        $response = $this->postJson('/api/events', [
            'event_type_id' => $eventType->id,
            'payload' => ['amount' => 5000],
        ]);

        $response->assertCreated()->assertJsonPath('deliveries', 1);
        $this->assertDatabaseCount('deliveries', 1);
    }

    public function test_a_failed_delivery_dispatches_an_event(): void
    {
        Event::fake([WebhookDeliveryFailed::class]);
        Http::fake(['*' => Http::response('', 500)]);

        $tenant = Tenant::factory()->create();
        $eventType = EventType::factory()->create(['tenant_id' => $tenant->id]);
        $endpoint = Endpoint::factory()->create(['tenant_id' => $tenant->id, 'is_active' => true]);
        $eventType->endpoints()->attach($endpoint);

        $this->postJson('/api/events', [
            'event_type_id' => $eventType->id,
            'payload' => ['amount' => 5000],
        ])->assertCreated();

        Event::assertDispatched(WebhookDeliveryFailed::class);
    }
}
