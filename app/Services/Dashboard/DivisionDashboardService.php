<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Repositories\Dashboard\DivisionDashboardRepository;
use App\Services\Dashboard\Contracts\DashboardDataServiceInterface;

class DivisionDashboardService implements DashboardDataServiceInterface
{
    protected DivisionDashboardRepository $repository;

    public function __construct()
    {
        $this->repository = new DivisionDashboardRepository();
    }

    public function getData(User $user, array $filters = []): array
    {
        return [
            'type' => 'division',
            'total_divisions' => 15,
            'total_kpi' => 320,
            'generated_by' => $user->name,
        ];
    }

}
