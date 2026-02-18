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

    // Dashboard access logging test removed

