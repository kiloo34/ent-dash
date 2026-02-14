<?php

namespace App\Services\Dashboard;

class SuperAdminResolver extends DashboardResolver
{
    public function resolveRoute(): string
    {
        return 'superadmin.dashboard';
    }

    public function resolveServices(): array
    {
        return [
            'branch' => new BranchDashboardService(),
            'division' => new DivisionDashboardService(),
        ];
    }

}
