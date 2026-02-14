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

    public function showBranch(Request $request)
    {
        $resolver = DashboardResolverFactory::make(auth()->user());
        $services = $resolver->resolveServices();

        $filters = $request->only([
            'start_date',
            'end_date',
            'region',
        ]);

        $data = $services['branch']->getData(auth()->user(), $filters);

        return response()->json($data);
    }


    public function showDivision()
    {
        $resolver = DashboardResolverFactory::make(auth()->user());

        $services = $resolver->resolveServices();

        $data = $services['division']->getData(auth()->user());

        return response()->json($data);
    }

}
