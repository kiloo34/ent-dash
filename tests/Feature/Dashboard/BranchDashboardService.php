<?php

use App\Models\User;
use App\Services\Dashboard\BranchDashboardService;

test('branch dashboard service returns correct structure', function () {

    $user = User::factory()->create();

    $service = new BranchDashboardService();

    $data = $service->getData($user);

    expect($data)->toHaveKeys([
        'type',
        'total_branches',
        'total_transactions',
        'generated_by',
    ]);
});

test('edm user can access branch dashboard endpoint', function () {

    $user = User::role('edm-admin')->first();

    $response = $this->actingAs($user)
        ->get(route('edm.branch'));

    $response->assertStatus(200);
});

test('branch dashboard applies date filter', function () {

    $user = User::role('edm-admin')->first();

    $response = $this->actingAs($user)
        ->get(route('edm.branch', [
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-31',
        ]));

    $response->assertStatus(200);
});