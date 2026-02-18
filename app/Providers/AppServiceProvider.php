<?php

namespace App\Providers;

use App\Policies\DashboardPolicy;
use Carbon\CarbonImmutable;
use Gate;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->registerMonitoring();
        Gate::define('viewDashboard', [DashboardPolicy::class, 'viewDashboard']);

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Failed::class,
            \App\Listeners\LogFailedLogin::class
        );
    }

    protected function registerMonitoring(): void
    {
        DB::listen(function ($query) {
            $threshold = config('dashboard.monitoring.slow_query_threshold', 500);
            if ($query->time > $threshold) {
                \Log::warning('Slow query detected', [
                    'sql' => $query->sql,
                    'bindings' => $this->maskSensitiveBindings($query->bindings),
                    'time' => $query->time,
                    'url' => request()->fullUrl(),
                ]);
            }
        });
    }

    protected function maskSensitiveBindings(array $bindings): array
    {
        // Simple masking for common sensitive fields if they appear in bindings
        return array_map(function ($value) {
            return is_string($value) && (str_contains($value, 'password') || strlen($value) > 100) 
                ? '********' 
                : $value;
        }, $bindings);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }    
}
