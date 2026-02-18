<?php

use App\DTOs\DashboardFilterDto;
use App\Models\User;
use App\Repositories\Dashboard\BranchDashboardRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = new BranchDashboardRepository();
    $this->seed(); // Seed standard roles
});

test('super admin sees all data', function () {
    // Arrange
    $user = User::factory()->create();
    $user->assignRole(\App\Enums\RoleType::SUPER_ADMIN->value);

    createTransactions();

    $filters = new DashboardFilterDto(null, null, null);

    // Act
    $result = $this->repository->getSummary($user, $filters);

    // Assert
    expect($result['total_transactions'])->toBe(2)
        ->and($result['total_branches'])->toBe(2);
});

test('edm member sees only own division data', function () {
    // Arrange
    $divisionA = \App\Models\OrganizationUnit::factory()->create(['name' => 'Div A']);
    $divisionB = \App\Models\OrganizationUnit::factory()->create(['name' => 'Div B']);

    $user = User::factory()->create(['organization_unit_id' => $divisionA->id]);
    $user->assignRole(\App\Enums\RoleType::EDM_MEMBER->value);

    // TX for Division A
    DB::table('app.transactions')->insert([
        'transaction_number' => 'TX_A',
        'transaction_date' => '2026-01-01',
        'branch_id' => 1,
        'division_id' => $divisionA->id,
        'region_code' => 'JATIM',
        'amount' => 1000,
    ]);

    // TX for Division B
    DB::table('app.transactions')->insert([
        'transaction_number' => 'TX_B',
        'transaction_date' => '2026-01-01',
        'branch_id' => 2,
        'division_id' => $divisionB->id,
        'region_code' => 'JATIM',
        'amount' => 1000,
    ]);

    $filters = new DashboardFilterDto(null, null, null);

    // Act
    $result = $this->repository->getSummary($user, $filters);

    // Assert
    expect($result['total_transactions'])->toBe(1);
});

test('get summary with empty filters handles gracefully', function () {
     // Arrange
     $user = User::factory()->create();
     $user->assignRole(\App\Enums\RoleType::SUPER_ADMIN->value);

     $filters = new DashboardFilterDto(null, null, null);

     // Act
     $result = $this->repository->getSummary($user, $filters);

     // Assert
     expect($result)
        ->toHaveKeys(['total_branches', 'total_transactions']);
});

function createTransactions()
{
    $orgUnit = \App\Models\OrganizationUnit::factory()->create();

    DB::table('app.transactions')->insert([
        [
            'transaction_number' => 'TX1',
            'branch_id' => 1,
            'division_id' => $orgUnit->id,
            'region_code' => 'REG1',
            'amount' => 100,
            'transaction_date' => '2026-01-01',
        ],
        [
            'transaction_number' => 'TX2',
            'branch_id' => 2,
            'division_id' => $orgUnit->id,
            'region_code' => 'REG2',
            'amount' => 200,
            'transaction_date' => '2026-01-02',
        ],
    ]);
}
