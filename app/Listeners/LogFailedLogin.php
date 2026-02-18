<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;

class LogFailedLogin
{
    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        $username = $event->credentials[config('fortify.username')] ?? 'unknown';
        $ip = request()->ip();
        
        Log::warning('Login attempt failed', [
            'username' => $username,
            'ip' => $ip,
            'guard' => $event->guard,
        ]);

        // Key for tracking consecutive failures per username + IP
        $key = 'consecutive_login_failures:'.$username.'|'.$ip;
        
        RateLimiter::hit($key, 3600); // Record failure for 1 hour

        $failures = RateLimiter::attempts($key);

        if ($failures >= 5) {
            Log::critical('Brute force alert: Multiple failed login attempts detected!', [
                'username' => $username,
                'ip' => $ip,
                'attempts' => $failures,
            ]);

            // Note: In a real enterprise app, you would send an email or Slack notification here:
            // Notification::route('slack', config('services.slack.hook'))->notify(new BruteForceAlert($username, $ip));
        }
    }
}
