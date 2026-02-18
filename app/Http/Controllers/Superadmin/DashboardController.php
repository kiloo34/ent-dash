<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardResolverFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AuthorizesRequests;
    /**
     * Dashboard Redirect Resolver
     * 
     * Handles the redirection of users to their specific dashboard route 
     * based on their role and organizational unit.
     */
    public function index()
    {
        $resolver = DashboardResolverFactory::make(auth()->user());

        return redirect()->route(
            $resolver->resolveRoute()
        );
    }

    /**
     * Show Superadmin Dashboard
     * 
     * Renders the administrative dashboard with system metrics and trends.
     */
    public function show()
    {
        $resolver = DashboardResolverFactory::make(auth()->user());
        $data = $resolver->resolveServices();

        return view('superadmin.dashboard', $data);
    }
}
