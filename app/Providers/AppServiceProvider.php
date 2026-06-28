<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\WebhookDeliveryFailed;
use App\Listeners\LogFailedDelivery;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(WebhookDeliveryFailed::class, LogFailedDelivery::class);
        RateLimiter::for('ingest', fn(Request $request) => Limit::perMinute(60)->by($request->ip()));
    }
}
