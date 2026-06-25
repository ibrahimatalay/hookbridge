<?php

namespace App\Services;

use App\Enums\DeliveryStatus;
use App\Models\Delivery;
use Illuminate\Support\Collection;

class DeliveryReportService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function endpointHealth(): Collection
    {
        return Delivery::with('endpoint')
            ->get()
            ->groupBy('endpoint_id')
            ->map(function (Collection $group) {
                $total = $group->count();
                $success = $group->where('status', DeliveryStatus::Success)->count();
                $failed = $group->where('status', DeliveryStatus::Failed)->count();

                return [
                    'endpoint' => $group->first()->endpoint?->url ?? '(inactive)',
                    'total' => $total,
                    'success' => $success,
                    'failed' => $failed,
                    'success_rate' => $total > 0 ? round(($success / $total) * 100, 1) : 0.0
                ];
            })
            ->sortByDesc('total')
            ->values();
    }
}
