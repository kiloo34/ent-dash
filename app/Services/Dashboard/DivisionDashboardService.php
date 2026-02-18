<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Repositories\Dashboard\DivisionDashboardRepository;
use App\Services\Dashboard\Contracts\DashboardDataServiceInterface;

use App\Repositories\Dashboard\Contracts\DivisionDashboardRepositoryInterface;

class DivisionDashboardService implements DashboardDataServiceInterface
{
    protected DivisionDashboardRepositoryInterface $repository;

    public function __construct(DivisionDashboardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getData(User $user, \App\DTOs\DashboardFilterDto $filters): \App\DTOs\DashboardSummaryDto
    {
        $summary = $this->repository->getSummary($user, $filters);

        return new \App\DTOs\DashboardSummaryDto(
            type: 'division',
            filters: $filters,
            data: $summary,
        );
    }

}
