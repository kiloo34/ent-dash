<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardResolverFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $resolver = DashboardResolverFactory::make(auth()->user());

        return redirect()->route(
            $resolver->resolveRoute()
        );
    }

    public function showBranch(\App\Http\Requests\Dashboard\BranchDashboardRequest $request)
    {
        $this->authorize('viewDashboard');

        try {
            $user = auth()->user();
            $resolver = DashboardResolverFactory::make($user);
            $services = $resolver->resolveServices();

            $filters = \App\DTOs\DashboardFilterDto::fromRequest($request);

            \Log::channel('enterprise')->info('Dashboard Access: Branch', [
                'user_id' => $user->id,
                'region' => $filters->region,
                'period' => [
                    'start' => $filters->startDate,
                    'end' => $filters->endDate
                ]
            ]);

            $data = $services['branch']->getData($user, $filters);

            return new \App\Http\Resources\DashboardSummaryResource($data);
        } catch (\Exception $e) {
            \Log::channel('enterprise')->error('Dashboard Error: Branch', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            throw $e;
        }
    }


    public function showDivision(Request $request)
    {
        $this->authorize('viewDashboard');

        try {
            $user = auth()->user();
            $resolver = DashboardResolverFactory::make($user);
            $services = $resolver->resolveServices();

            $filters = \App\DTOs\DashboardFilterDto::fromRequest($request);

            \Log::channel('enterprise')->info('Dashboard Access: Division', [
                'user_id' => $user->id,
                'filters' => $request->all()
            ]);

            $data = $services['division']->getData($user, $filters);

            return new \App\Http\Resources\DashboardSummaryResource($data);
        } catch (\Exception $e) {
            \Log::channel('enterprise')->error('Dashboard Error: Division', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

}
