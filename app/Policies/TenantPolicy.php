<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    public function manage(User $user, Tenant $tenant): bool
    {
        return $user->tenant_id === $tenant->id;
    }
}
