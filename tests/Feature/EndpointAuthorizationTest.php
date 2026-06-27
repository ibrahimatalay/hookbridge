<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class EndpointAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_another_tenants_endpoints(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenantA->id]);

        Sanctum::actingAs($user, ['*']);

        $this->getJson('/api/tenants/' . $tenantB->id . '/endpoints')->assertForbidden();
    }

    public function test_user_can_access_their_own_tenants_endpoints(): void
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        Sanctum::actingAs($user, ['*']);

        $this->getJson('/api/tenants/' . $tenant->id . '/endpoints')->assertOk();
    }
}
