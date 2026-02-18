<?php

namespace App\Repositories\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Repositories\Dashboard\Contracts\DivisionDashboardRepositoryInterface;

class DivisionDashboardRepository implements DivisionDashboardRepositoryInterface
{

    public function getSummary(User $user, \App\DTOs\DashboardFilterDto $filters): \Illuminate\Support\Collection
    {
        $query = DB::table('app.transactions');
        $query = $this->applyVisibility($query, $user);

        if ($filters->startDate) {
            $query->whereDate('transaction_date', '>=', $filters->startDate);
        }

        if ($filters->endDate) {
            $query->whereDate('transaction_date', '<=', $filters->endDate);
        }

        if ($filters->region) {
            $query->where('region_code', $filters->region);
        }

        $version = cache()->get('dashboard_cache_version', 'default');
        $cacheKey = 'v' . $version . '_division_dashboard_' . $user->id . '_' . md5(json_encode((array)$filters));

        return cache()->remember($cacheKey, config('dashboard.cache.ttl'), function () use ($query, $user) {
            $result = $query->selectRaw('count(distinct division_id) as total_divisions, count(*) as total_kpi')->first();

            return collect([
                'total_divisions' => $result->total_divisions,
                'total_kpi' => $result->total_kpi,
                'generated_by' => $user->name,
            ]);
        });
    }

    private function applyVisibility($query, User $user)
    {
        if ($user->hasAnyRole([
            \App\Enums\RoleType::EDM_ADMIN->value,
            \App\Enums\RoleType::SUPER_ADMIN->value
        ])) {
            return $query;
        }

        return $query->where('division_id', $user->organization_unit_id);
    }

}
