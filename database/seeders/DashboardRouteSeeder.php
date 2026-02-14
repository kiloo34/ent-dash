<?php

namespace Database\Seeders;

use App\Models\Feature\Config\DashboardRoute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DashboardRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DashboardRoute::updateOrCreate(
            ['role_name' => 'super-admin'],
            ['route_name' => 'superadmin.dashboard']
        );

        DashboardRoute::updateOrCreate(
            ['role_name' => 'edm-admin'],
            ['route_name' => 'edm.dashboard']
        );

        DashboardRoute::updateOrCreate(
            ['role_name' => 'edm-member'],
            ['route_name' => 'edm.dashboard']
        );
    }

}
