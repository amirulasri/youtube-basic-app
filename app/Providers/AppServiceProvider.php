<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('youtube-search', function (Request $request) {
            $user = $request->user();
            if ($user && in_array('premium', $user->capabilities ?? [])) {
                // more generous for premium students: 60 per minute
                return Limit::perMinute(60)->by($user->id ?: $request->ip());
            }

            // default: 10 per minute per user or IP
            return Limit::perMinute(10)->by($user->id ?: $request->ip());
        });
    }
}
