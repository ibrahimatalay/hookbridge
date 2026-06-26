<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[ScopedBy([ActiveScope::class])]
#[Fillable(['tenant_id', 'url', 'is_active'])]
class Endpoint extends Model
{
    /** @use HasFactory<\Database\Factories\EndpointFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function eventTypes(): BelongsToMany
    {
        return $this->belongsToMany(EventType::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
