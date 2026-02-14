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
            'branch' => new BranchDashboardService(),
            'division' => new DivisionDashboardService(),
        ];
    }

}
