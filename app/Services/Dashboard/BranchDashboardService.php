<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Repositories\Dashboard\BranchDashboardRepository;
use App\Services\Dashboard\Contracts\DashboardDataServiceInterface;

class BranchDashboardService implements DashboardDataServiceInterface
{
    protected BranchDashboardRepository $repository;

    public function __construct()
    {
        $this->repository = new BranchDashboardRepository();
    }

    public function getData(User $user, array $filters = []): array
    {
        $summary = $this->repository->getSummary($user, $filters);

        return [
            'type' => 'branch',
            'filters' => $filters,
            'data' => $summary,
        ];
    }
}
