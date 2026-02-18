<?php

use App\Models\User;
use App\Models\Transaction;
use App\Models\OrganizationUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('dashboard cache is invalidated when a transaction is created', function () {
    $user = User::role(\App\Enums\RoleType::EDM_ADMIN->value)->first();
    $orgUnit = OrganizationUnit::factory()->create();

    // 1. Initial request to populate cache
    $response1 = $this->actingAs($user)->get(route('edm.branch'));
    $response1->assertStatus(200);
    $initialTotal = $response1->json('data.total_transactions');

    // 2. Create a new transaction (should trigger observer)
    Transaction::create([
        'transaction_number' => 'TX_CACHE_TEST',
        'transaction_date' => now(),
        'branch_id' => 1,
        'division_id' => $orgUnit->id,
        'region_code' => 'JATIM',
        'amount' => 500,
    ]);

    // 3. Second request - should see updated data because version changed
    $response2 = $this->actingAs($user)->get(route('edm.branch'));
    $response2->assertStatus(200);
    $newTotal = $response2->json('data.total_transactions');

    expect($newTotal)->toBe($initialTotal + 1);
});
