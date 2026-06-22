<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_type_id' => EventType::factory(),
            'payload' => [
                'id' => fake()->uuid(),
                'amount' => fake()->numberBetween(100, 50000),
                'currency' => fake()->randomElement(['USD', 'EUR', 'TRY']),
            ],
            'idempotency_key' => fake()->unique()->uuid(),
            'occurred_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
