<?php

namespace App\Services\Dashboard;

class EdmResolver extends DashboardResolver
{
    public function resolveRoute(): string
    {
        return 'dashboard';
    }

    public function resolveServices(): array
    {
        return [];
    }

}
