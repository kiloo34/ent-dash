<?php

namespace Tests\Unit\Services\Dashboard;

use App\DTOs\DashboardFilterDto;
use App\DTOs\DashboardSummaryDto;
use App\Repositories\Dashboard\Contracts\BranchDashboardRepositoryInterface;
use App\Services\Dashboard\BranchDashboardService;
use App\Models\User;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class BranchDashboardServiceTest extends TestCase
{
    public function test_it_returns_correct_dashboard_summary_dto()
    {
        // 1. Arrange: Prepare Mocks and Input
        $user = User::factory()->make();
        $filters = new DashboardFilterDto(null, null, null);
        $expectedCollection = collect(['total' => 10]);

        // Mock the Repository Interface
        $repositoryMock = Mockery::mock(BranchDashboardRepositoryInterface::class);
        $repositoryMock->shouldReceive('getSummary')
            ->once()
            ->with($user, $filters)
            ->andReturn($expectedCollection);

        // Instantiate Service with Mock
        $service = new BranchDashboardService($repositoryMock);

        // 2. Act: Call the method
        $result = $service->getData($user, $filters);

        // 3. Assert: Verify the output
        $this->assertInstanceOf(DashboardSummaryDto::class, $result);
        $this->assertEquals('branch', $result->type);
        $this->assertEquals($expectedCollection, $result->data);
    }
}
