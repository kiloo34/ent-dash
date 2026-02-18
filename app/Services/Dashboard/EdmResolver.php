<?php

namespace App\Services\Dashboard;

class EdmResolver extends DashboardResolver
{
    public function resolveRoute(): string
    {
        return 'edm.dashboard';
    }

    public function resolveServices(): array
    {
        return [
            'branch' => app(\App\Services\Dashboard\BranchDashboardService::class),
            'division' => app(\App\Services\Dashboard\DivisionDashboardService::class),
        ];
    }

}
