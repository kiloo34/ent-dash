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

        // Positions
        $direkturPos = Position::where('name', 'Direktur')->first();
        $sevpPos = Position::where('name', 'SEVP')->first();
        $vpPos = Position::where('name', 'VP')->first();
        $avpPos = Position::where('name', 'AVP')->first();
        $officerPos = Position::where('name', 'Officer')->first();

        // Units
        $direktorat = OrganizationUnit::where('pluck_code', 'DIR_TI')->first();
        $sevpTI = OrganizationUnit::where('pluck_code', 'SEVP_TI')->first();
        $divisiTI = OrganizationUnit::where('pluck_code', 'DIV_TI')->first();
        $divisiDigital = OrganizationUnit::where('pluck_code', 'DIV_DIG')->first();
        $subEdm = OrganizationUnit::where('pluck_code', 'EDM')->first();

        // 1. Direktur TI (ADMIN)
        $direktur = User::updateOrCreate(
            ['email' => 'direktur.ti@company.com'],
            ['name' => 'Direktur TI', 'password' => Hash::make('password'), 'position_id' => $direkturPos->id, 'organization_unit_id' => $direktorat->id]
        );
        $direktur->assignRole(\App\Enums\RoleType::ADMIN->value);

        // 2. SEVP TI
        $sevp = User::updateOrCreate(
            ['email' => 'sevp.ti@company.com'],
            ['name' => 'SEVP TI', 'password' => Hash::make('password'), 'position_id' => $sevpPos->id, 'organization_unit_id' => $sevpTI->id, 'direct_superior_id' => $direktur->id]
        );
        $sevp->assignRole(\App\Enums\RoleType::ADMIN->value);

        // 3. VP TI (Head of Divisi TI)
        $vpTI = User::updateOrCreate(
            ['email' => 'vp.ti@company.com'],
            ['name' => 'VP TI', 'password' => Hash::make('password'), 'position_id' => $vpPos->id, 'organization_unit_id' => $divisiTI->id, 'direct_superior_id' => $sevp->id]
        );
        $vpTI->assignRole(\App\Enums\RoleType::ADMIN->value);

        // 4. VP Digital (Head of Divisi Digital Banking)
        $vpDigital = User::updateOrCreate(
            ['email' => 'vp.digital@company.com'],
            ['name' => 'VP Digital Banking', 'password' => Hash::make('password'), 'position_id' => $vpPos->id, 'organization_unit_id' => $divisiDigital->id, 'direct_superior_id' => $sevp->id]
        );
        $vpDigital->assignRole(\App\Enums\RoleType::ADMIN->value);

        // 5. AVP EDM (Under Divisi TI)
        $avpEdm = User::updateOrCreate(
            ['email' => 'avp.edm@company.com'],
            ['name' => 'AVP EDM', 'password' => Hash::make('password'), 'position_id' => $avpPos->id, 'organization_unit_id' => $subEdm->id, 'direct_superior_id' => $vpTI->id]
        );
        $avpEdm->assignRole(\App\Enums\RoleType::ADMIN->value);

        // 6. Super Admin (Officer EDM - Member)
        $officerEdm = User::updateOrCreate(
            ['email' => 'officer.edm@company.com'],
            ['name' => 'Officer EDM', 'password' => Hash::make('password'), 'position_id' => $officerPos->id, 'organization_unit_id' => $subEdm->id, 'direct_superior_id' => $avpEdm->id]
        );
        $officerEdm->assignRole(\App\Enums\RoleType::SUPER_ADMIN->value);
    }
}
