<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]
class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory;

    public function endpoints(): HasMany
    {
        return $this->hasMany(Endpoint::class);
    }

    public function eventTypes(): HasMany
    {
        return $this->hasMany(EventType::class);
    }

    public function events(): HasManyThrough
    {
        return $this->hasManyThrough(Event::class, EventType::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
