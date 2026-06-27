<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class EndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_an_endpoint_for_their_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/tenants/' . $tenant->id . '/endpoints', [
            'url' => 'https://example.com/webhook',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('endpoints', [
            'tenant_id' => $tenant->id,
            'url' => 'https://example.com/webhook',
        ]);
    }

    public function test_creating_an_endpoint_requires_a_url(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        Sanctum::actingAs($user, ['*']);

        $this->postJson('/api/tenants/' . $tenant->id . '/endpoints', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('url');
    }
}
