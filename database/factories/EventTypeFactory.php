<?php

namespace Database\Factories;

use App\Models\EventType;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventType>
 */
class EventTypeFactory extends Factory
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
            'name' => fake()->randomElement([
                'order.created',
                'order.updated',
                'payment.succeeded',
            ]),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
