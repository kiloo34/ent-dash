<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('slow query monitoring logs queries exceeding threshold', function () {
    Log::shouldReceive('warning')
        ->once()
        ->with('Slow query detected', Mockery::on(function ($context) {
            return isset($context['sql']) && isset($context['time']);
        }));

    // Set threshold to 0 to trigger log for any query
    config(['dashboard.monitoring.slow_query_threshold' => -1]);

    DB::table('users')->get();
});

test('dashboard controller logs access and errors', function () {
    $user = User::role(\App\Enums\RoleType::EDM_ADMIN->value)->first();

    Log::shouldReceive('channel')
        ->with('enterprise')
        ->andReturnSelf();

    Log::shouldReceive('info')
        ->once()
        ->with('Dashboard Access: Branch', Mockery::on(function ($context) use ($user) {
            return $context['user_id'] === $user->id;
        }));

    $response = $this->actingAs($user)->get(route('edm.branch'));
    $response->assertStatus(200);
});
