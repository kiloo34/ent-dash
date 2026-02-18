<?php

namespace App\Services\Dashboard;

use App\Models\User;


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
                \App\Enums\RoleType::ADMIN, 
                \App\Enums\RoleType::MEMBER => EdmResolver::class,
                default => null,
            };

            if ($resolverClass) {
                return new $resolverClass($user);
            }
        }

        abort(403, 'No dashboard resolver found for your roles.');
    }
}
