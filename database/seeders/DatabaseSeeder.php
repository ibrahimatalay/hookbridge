<?php

namespace Database\Seeders;

use App\Models\Endpoint;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $eventTypeNames = [
            'order.created',
            'order.updated',
            'order.shipped',
            'payment.succeeded',
            'payment.failed',
            'user.registered',
        ];

        Tenant::factory(5)
            ->create()
            ->each(function (Tenant $tenant) use ($eventTypeNames) {
                Endpoint::factory(3)->for($tenant)->create();

                collect($eventTypeNames)
                    ->random(rand(3, 5))
                    ->each(function (string $name) use ($tenant) {
                        $eventType = EventType::factory()
                            ->for($tenant)
                            ->create(['name' => $name]);

                        Event::factory(rand(20, 50))
                            ->for($eventType)
                            ->create();
                    });
            });
    }
}
