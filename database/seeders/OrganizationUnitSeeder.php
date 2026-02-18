<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrganizationUnit;

class OrganizationUnitSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Level Direktorat
        $direktorat = OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'DIR_TI'],
            ['name' => 'Direktorat TI', 'type' => 'directorate', 'parent_id' => null]
        );

        // 2. Level SEVP
        $sevp = OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'SEVP_TI'],
            ['name' => 'SEVP TI', 'type' => 'sevp', 'parent_id' => $direktorat->id]
        );

        // 3. Level Divisi (VP)
        $divisiTI = OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'DIV_TI'],
            ['name' => 'Divisi TI', 'type' => 'division', 'parent_id' => $sevp->id]
        );

        $divisiDigital = OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'DIV_DIG'],
            ['name' => 'Divisi Digital Banking', 'type' => 'division', 'parent_id' => $sevp->id]
        );

        $divisiUmum = OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'DIV_UMUM'],
            ['name' => 'Divisi Umum', 'type' => 'division', 'parent_id' => $sevp->id]
        );

        // 4. Level Sub-Divisi (AVP)
        // Sub Divisi di TI
        OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'EDM'],
            ['name' => 'Enterprise Data Management', 'type' => 'subdivision', 'parent_id' => $divisiTI->id]
        );

        OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'OPS_TI'],
            ['name' => 'Operasional TI', 'type' => 'subdivision', 'parent_id' => $divisiTI->id]
        );

        // Sub Divisi di Digital Banking
        OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'DEV_DIG'],
            ['name' => 'Pengembangan Digital', 'type' => 'subdivision', 'parent_id' => $divisiDigital->id]
        );

        OrganizationUnit::updateOrCreate(
            ['pluck_code' => 'QA_DIG'],
            ['name' => 'QA Digital', 'type' => 'subdivision', 'parent_id' => $divisiDigital->id]
        );
    }
}
