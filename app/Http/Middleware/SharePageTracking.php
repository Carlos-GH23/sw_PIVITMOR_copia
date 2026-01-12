<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class SharePageTracking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share('pageTracking', function () use ($request) {
            $activityId = $request->attributes->get('visit_activity_id');
            $moduleKey = $request->attributes->get('visit_module_key');

            if (!$activityId || !$moduleKey) {
                return null;
            }

            return [
                'activityId' => $activityId,
                'moduleKey' => $moduleKey,
                'interval' => config('reporting.duration.heartbeat_interval', 30) * 1000,
            ];
        });

        return $next($request);
    }
}
