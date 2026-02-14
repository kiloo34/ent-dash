<?php

namespace App\Services\Dashboard\Contracts;

use App\Models\User;

interface DashboardDataServiceInterface
{
    public function getData(User $user, array $filters = []): array;
}
