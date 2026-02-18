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
            'branch' => app(BranchDashboardService::class),
            'division' => app(DivisionDashboardService::class),
        ];
    }

}
