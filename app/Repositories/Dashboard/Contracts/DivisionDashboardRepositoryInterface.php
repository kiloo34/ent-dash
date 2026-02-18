<?php

namespace App\Repositories\Dashboard\Contracts;

use App\DTOs\DashboardFilterDto;
use App\Models\User;
use Illuminate\Support\Collection;

interface DivisionDashboardRepositoryInterface
{
    public function getSummary(User $user, DashboardFilterDto $filters): Collection;
}
