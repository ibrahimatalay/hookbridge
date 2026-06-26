<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\DeliveryStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['event_id', 'endpoint_id', 'status', 'attempts', 'response_status', 'delivered_at'])]
class Delivery extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'delivered_at' => 'datetime',
            'status' => DeliveryStatus::class,
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function endpoint(): BelongsTo
    {
        return $this->belongsTo(Endpoint::class);
    }
}
