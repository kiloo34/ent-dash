<?php

namespace Database\Seeders;

use App\Models\OrganizationUnit;
use App\Models\Position;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $sevp = Position::where('name', 'SEVP')->first();
        $vp = Position::where('name', 'VP')->first();
        $avp = Position::where('name', 'AVP')->first();
        $officer = Position::where('name', 'Officer')->first();

        $divisiIT = OrganizationUnit::where('name', 'Divisi IT')->first();
        $subEdm = OrganizationUnit::where('name', 'Subdivisi Enterprise Data Management')->first();

        // ===== SEVP =====
        $sevpUser = User::updateOrCreate(
            ['email' => 'sevp.it@company.com'],
            [
                'name' => 'SEVP IT',
                'password' => Hash::make('password'),
                'position_id' => $sevp->id,
                'organization_unit_id' => $divisiIT->id,
            ]
        );

        // ===== VP (Head of Division IT) =====
        $vpUser = User::updateOrCreate(
            ['email' => 'vp.it@company.com'],
            [
                'name' => 'VP IT',
                'password' => Hash::make('password'),
                'position_id' => $vp->id,
                'organization_unit_id' => $divisiIT->id,
                'direct_superior_id' => $sevpUser->id,
            ]
        );

        // ===== AVP (Head of Subdivision EDM) =====
        $avpUser = User::updateOrCreate(
            ['email' => 'avp.edm@company.com'],
            [
                'name' => 'AVP Enterprise Data Management',
                'password' => Hash::make('password'),
                'position_id' => $avp->id,
                'organization_unit_id' => $subEdm->id,
                'direct_superior_id' => $vpUser->id,
            ]
        );

        // ===== Officers per Group =====
        $groups = OrganizationUnit::where('type', 'group')
            ->whereIn('name', [
                'Group Data Analytics & Data Science',
                'Group Bussiness Intelligence',
                'Group Big Data & Data Warehouse',
            ])
            ->get();

        foreach ($groups as $group) {
            for ($i = 1; $i <= 3; $i++) {

                $user = User::updateOrCreate(
                    [
                        'email' => "{$group->pluck_code}.officer{$i}@company.com"
                    ],
                    [
                        'name' => $group->name . " Officer {$i}",
                        'password' => Hash::make('password'),
                        'position_id' => $officer->id,
                        'organization_unit_id' => $group->id,
                        'direct_superior_id' => $avpUser->id,
                    ]
                );
                
                if ($i === 1) {
                    $user->assignRole(\App\Enums\RoleType::SUPER_ADMIN->value); // 3 officer akan jadi super-admin
                } else if ($i === 2) {
                    $user->assignRole(\App\Enums\RoleType::EDM_ADMIN->value); // atau edm-member sesuai kebutuhan
                } else {
                    $user->assignRole(\App\Enums\RoleType::EDM_MEMBER->value); // atau edm-member sesuai kebutuhan
                }
            }
        }
    }
}
