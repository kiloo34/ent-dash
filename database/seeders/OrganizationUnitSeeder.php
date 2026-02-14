<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrganizationUnit;

class OrganizationUnitSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Divisi =====
        $divisiIT = OrganizationUnit::updateOrCreate(
            ['name' => 'Divisi IT', 'pluck_code' => 'IT'],
            ['type' => 'division', 'parent_id' => null, 'is_active' => true]
        );

        // ===== Subdivisi IT =====
        $subEdm = OrganizationUnit::updateOrCreate(
            ['name' => 'Subdivisi Enterprise Data Management', 'pluck_code' => 'EDM'],
            ['type' => 'subdivision', 'parent_id' => $divisiIT->id, 'is_active' => true]
        );

        // ===== Group IT =====
        OrganizationUnit::updateOrCreate(
            ['name' => 'Group Data Analytics & Data Science', 'pluck_code' => 'DADS'],
            ['type' => 'group', 'parent_id' => $subEdm->id, 'is_active' => true]
        );

        OrganizationUnit::updateOrCreate(
            ['name' => 'Group Bussiness Intelligence', 'pluck_code' => 'BI'],
            ['type' => 'group', 'parent_id' => $subEdm->id, 'is_active' => true]
        );

        OrganizationUnit::updateOrCreate(
            ['name' => 'Group Big Data & Data Warehouse', 'pluck_code' => 'BDDW'],
            ['type' => 'group', 'parent_id' => $subEdm->id, 'is_active' => true]
        );
    }
}
