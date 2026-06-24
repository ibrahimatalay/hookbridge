<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventType extends Model
{
    /** @use HasFactory<\Database\Factories\EventTypeFactory> */
    use HasFactory;

    protected $fillable = ['tenant_id', 'name', 'description'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function endpoints(): BelongsToMany
    {
        return $this->belongsToMany(Endpoint::class);
    }
}
