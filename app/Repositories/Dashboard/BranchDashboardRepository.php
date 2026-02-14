<?php

namespace App\Repositories\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class BranchDashboardRepository
{
    public function getSummary(User $user, array $filters = [])
    {
        $query = DB::table('transactions');

        if (!empty($filters['start_date'])) {
            $query->whereDate('transaction_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('transaction_date', '<=', $filters['end_date']);
        }

        if (!empty($filters['region'])) {
            $query->where('region_code', $filters['region']);
        }

        return [
            'total_branches' => $query->distinct('branch_id')->count('branch_id'),
            'total_transactions' => $query->count(),
        ];
    }

    private function applyVisibility($query, User $user)
    {
        if ($user->hasAnyRole(['edm-admin', 'edm-member', 'super-admin'])) {
            return $query;
        }

        return $query->where('division_id', $user->organization_unit_id);
    }

}
