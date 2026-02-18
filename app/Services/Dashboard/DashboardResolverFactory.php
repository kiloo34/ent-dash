<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\RoleContextResolver;

class DashboardResolverFactory
{
    public static function make(User $user): DashboardResolver
    {
        $roleValues = $user->roles->pluck('name')->toArray();

        foreach ($roleValues as $roleValue) {
            $role = \App\Enums\RoleType::tryFrom($roleValue);

            if (!$role) continue;

            $resolverClass = match ($role) {
                \App\Enums\RoleType::SUPER_ADMIN => SuperAdminResolver::class,
                \App\Enums\RoleType::EDM_ADMIN, \App\Enums\RoleType::EDM_MEMBER => EdmResolver::class,
                default => null,
            };

            if ($resolverClass) {
                return new $resolverClass($user);
            }
        }

        abort(403, 'No dashboard resolver found for your roles.');
    }
}
