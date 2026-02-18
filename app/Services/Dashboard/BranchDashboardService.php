<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Repositories\Dashboard\BranchDashboardRepository;
use App\Services\Dashboard\Contracts\DashboardDataServiceInterface;

use App\Repositories\Dashboard\Contracts\BranchDashboardRepositoryInterface;

class BranchDashboardService implements DashboardDataServiceInterface
{
    protected BranchDashboardRepositoryInterface $repository;

    public function __construct(BranchDashboardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getData(User $user, \App\DTOs\DashboardFilterDto $filters): \App\DTOs\DashboardSummaryDto
    {
        $summary = $this->repository->getSummary($user, $filters);

        return new \App\DTOs\DashboardSummaryDto(
            type: 'branch',
            filters: $filters,
            data: $summary,
        );
    }
}
