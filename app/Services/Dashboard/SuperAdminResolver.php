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
            'stats' => [
                'users' => \App\Models\User::count(),
                'units' => \App\Models\OrganizationUnit::count(),
                'positions' => \App\Models\Position::count(),
                'activity' => \Spatie\Activitylog\Models\Activity::count(),
            ],
            'recent_activity' => \Spatie\Activitylog\Models\Activity::with('causer')
                ->latest()
                ->take(5)
                ->get(),
        ];
    }

}
