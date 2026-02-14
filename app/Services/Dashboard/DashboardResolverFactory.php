<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\RoleContextResolver;

class DashboardResolverFactory
{
    public static function make(User $user): DashboardResolver
    {
        foreach ($user->roles as $role) {

            $mapping = RoleContextResolver::where('role_name', $role->name)
                ->where('context', 'dashboard')
                ->where('is_active', true)
                ->first();

            if ($mapping && class_exists($mapping->resolver_class)) {
                return new $mapping->resolver_class($user);
            }
        }

        abort(403, 'No dashboard resolver found.');
    }
}
