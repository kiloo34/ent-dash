<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // ========================
        // Permissions
        // ========================
        $permissions = [
            'view-dashboard',
            'view-branch-dashboard',
            'view-division-dashboard',
            'export-report',
            'manage-dashboard-config',
            'manage-report-config',
            'manage-user',
            'manage-role',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // ========================
        // Roles
        // ========================
        $superAdmin = Role::updateOrCreate(['name' => 'super-admin','guard_name' => 'web']);
        $edmAdmin = Role::updateOrCreate(['name' => 'edm-admin','guard_name' => 'web']);
        $edmMember = Role::updateOrCreate(['name' => 'edm-member','guard_name' => 'web']);

        // ========================
        // Mapping Permission
        // ========================

        // Super Admin → semua permission
        $superAdmin->syncPermissions(Permission::all());

        // EDM Admin
        $edmAdmin->syncPermissions([
            'view-dashboard',
            'view-branch-dashboard',
            'view-division-dashboard',
            'export-report',
            'manage-dashboard-config',
            'manage-report-config',
        ]);

        // EDM Member
        $edmMember->syncPermissions([
            'view-dashboard',
            'view-branch-dashboard',
            'view-division-dashboard',
            'export-report',
        ]);
    }
}
