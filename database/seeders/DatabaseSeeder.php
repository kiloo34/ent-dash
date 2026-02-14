<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            PositionSeeder::class,
            OrganizationUnitSeeder::class,
            RolePermissionSeeder::class,
            RoleContextResolverSeeder::class,
            UserSeeder::class,
        ]);
    }
}
