<?php

namespace App\Services\Dashboard;

use App\Models\User;

abstract class DashboardResolver
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
        
    abstract public function resolveRoute(): string;

    abstract public function resolveServices(): array;
}
