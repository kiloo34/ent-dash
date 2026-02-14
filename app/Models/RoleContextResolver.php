<?php

namespace App\Models;

use App\Services\Dashboard\DashboardResolver;
use Illuminate\Database\Eloquent\Model;

class RoleContextResolver extends Model
{
    protected $table = 'app.role_context_resolvers';
    
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
