<?php

namespace Database\Factories;

use App\Models\Endpoint;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Endpoint>
 */
class EndpointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'url' => fake()->url(),
            'is_active' => fake()->boolean(85),
        ];
    }
}
