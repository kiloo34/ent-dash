<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('edm admin can access branch dashboard endpoint', function () {

    $user = User::role(\App\Enums\RoleType::EDM_ADMIN->value)->first();
    dump($user->getRoleNames());
    $response = $this->actingAs($user)
        ->get(route('edm.branch'));

    $response->assertStatus(200);
});

test('user without permission cannot access branch dashboard', function () {

    $user = User::factory()->create();
    // User has no roles assigned

    $response = $this->actingAs($user)
        ->get(route('edm.branch'));

    $response->assertForbidden();
});

test('branch dashboard applies date filter correctly', function () {

    $orgUnit = \App\Models\OrganizationUnit::factory()->create();

    \DB::table('app.transactions')->insert([
        [
            'transaction_number' => 'TX100',
            'transaction_date' => '2026-01-01',
            'branch_id' => 1,
            'division_id' => $orgUnit->id,
            'region_code' => 'JATIM',
            'amount' => 1000,
        ],
        [
            'transaction_number' => 'TX200',
            'transaction_date' => '2026-02-01',
            'branch_id' => 2,
            'division_id' => $orgUnit->id,
            'region_code' => 'JATIM',
            'amount' => 2000,
        ],
    ]);

    $user = User::role(\App\Enums\RoleType::EDM_ADMIN->value)->first();

    $response = $this->actingAs($user)
        ->get(route('edm.branch', [
            'start_date' => '2026-01-01',
            'end_date'   => '2026-01-31',
        ]));

    $response->assertStatus(200)
        ->assertJsonPath('data.total_transactions', 1);
});

test('branch dashboard handles empty filters gracefully', function () {
    $user = User::role(\App\Enums\RoleType::EDM_ADMIN->value)->first();

    $response = $this->actingAs($user)
        ->get(route('edm.branch')); // No parameters

    $response->assertStatus(200)
        ->assertJsonStructure([
            'type',
            'meta' => [
                'period' => ['start', 'end'],
                'region'
            ],
            'data' => ['total_branches', 'total_transactions']
        ]);
});

test('non edm user sees only their division data', function () {

    $otherOrgUnit = \App\Models\OrganizationUnit::factory()->create();

    \DB::table('app.transactions')->insert([
        [
            'transaction_number' => 'TX300',
            'transaction_date' => '2026-01-01',
            'branch_id' => 1,
            'division_id' => $otherOrgUnit->id,
            'region_code' => 'JATIM',
            'amount' => 1000,
        ],
    ]);

    $userOrgUnit = \App\Models\OrganizationUnit::factory()->create();

    $user = User::factory()->create([
        'organization_unit_id' => $userOrgUnit->id,
    ]);
    $user->assignRole(\App\Enums\RoleType::EDM_MEMBER->value);

    $response = $this->actingAs($user)
        ->get(route('edm.branch'));

    $response->assertStatus(200)
        ->assertJsonPath('data.total_transactions', 0);
});
