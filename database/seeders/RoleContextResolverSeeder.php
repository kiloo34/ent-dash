<?php

namespace Database\Seeders;

use App\Models\RoleContextResolver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleContextResolverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleContextResolver::updateOrCreate(
            [
                'role_name' => \App\Enums\RoleType::SUPER_ADMIN->value,
                'context'   => 'dashboard',
            ],
            [
                'resolver_class' => \App\Services\Dashboard\SuperAdminResolver::class,
                'is_active'      => true,
            ]
        );

        RoleContextResolver::updateOrCreate(
            [
                'role_name' => \App\Enums\RoleType::EDM_ADMIN->value,
                'context'   => 'dashboard',
            ],
            [
                'resolver_class' => \App\Services\Dashboard\EdmResolver::class,
                'is_active'      => true,
            ]
        );

        RoleContextResolver::updateOrCreate(
            [
                'role_name' => \App\Enums\RoleType::EDM_MEMBER->value,
                'context'   => 'dashboard',
            ],
            [
                'resolver_class' => \App\Services\Dashboard\EdmResolver::class,
                'is_active'      => true,
            ]
        );
    }
}
