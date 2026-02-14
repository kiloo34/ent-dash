<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('edm admin can access branch dashboard endpoint', function () {

    $user = User::role('edm-admin')->first();
    dump($user->getRoleNames());
    $response = $this->actingAs($user)
        ->get(route('edm.branch'));

    $response->assertStatus(200);
});

// test('user without permission cannot access branch dashboard', function () {

//     $user = User::factory()->create();

//     $response = $this->actingAs($user)
//         ->get(route('edm.branch'));

//     $response->assertForbidden();
// });

// test('branch dashboard applies date filter correctly', function () {

//     \DB::table('transactions')->insert([
//         [
//             'transaction_number' => 'TX100',
//             'transaction_date' => '2026-01-01',
//             'branch_id' => 1,
//             'division_id' => 10,
//             'region_code' => 'JATIM',
//             'amount' => 1000,
//         ],
//         [
//             'transaction_number' => 'TX200',
//             'transaction_date' => '2026-02-01',
//             'branch_id' => 2,
//             'division_id' => 10,
//             'region_code' => 'JATIM',
//             'amount' => 2000,
//         ],
//     ]);

//     $user = User::role('edm-admin')->first();

//     $response = $this->actingAs($user)
//         ->get(route('edm.branch', [
//             'start_date' => '2026-01-01',
//             'end_date'   => '2026-01-31',
//         ]));

//     $response->assertStatus(200)
//         ->assertJsonPath('data.total_transactions', 1);
// });

// test('non edm user sees only their division data', function () {

//     \DB::table('transactions')->insert([
//         [
//             'transaction_number' => 'TX300',
//             'transaction_date' => '2026-01-01',
//             'branch_id' => 1,
//             'division_id' => 999,
//             'region_code' => 'JATIM',
//             'amount' => 1000,
//         ],
//     ]);

//     $user = User::factory()->create([
//         'organization_unit_id' => 10,
//     ]);

//     $response = $this->actingAs($user)
//         ->get(route('edm.branch'));

//     $response->assertStatus(200)
//         ->assertJsonPath('data.total_transactions', 0);
// });
