<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response;

class LogModuleVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleKey): Response
    {
        if (!$request->isMethod('get') || !Auth::check()) {
            return $next($request);
        }

        $trackableModules = array_keys(config('reporting.modules', []));

        if (!in_array($moduleKey, $trackableModules)) {
            return $next($request);
        }

        $user = Auth::user();
        $role = $user->roles->first();

        $existingActivity = Activity::where('log_name', 'system_module_visit')
            ->where('causer_id', $user->id)
            ->where('module_key', $moduleKey)
            ->whereDate('created_at', today())
            ->first();

        if ($existingActivity) {
            $existingActivity->update([
                'last_heartbeat_at' => now(),
                'updated_at' => now(),
            ]);

            $properties = $existingActivity->properties ?? [];
            $properties['last_visit'] = [
                'url' => $request->fullUrl(),
                'route_name' => $request->route()?->getName(),
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ];

            $existingActivity->update(['properties' => $properties]);

            $activity = $existingActivity;
        } else {
            $activity = activity('system_module_visit')
                ->causedBy($user)
                ->withProperties([
                    'url' => $request->fullUrl(),
                    'route_name' => $request->route()?->getName(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_id' => $request->session()->getId(),
                    'first_visit' => now()->toDateTimeString(),
                ])
                ->event('visit')
                ->log("Visitó: {$moduleKey}");

            if ($activity instanceof Activity) {
                $activity->update([
                    'module_key' => $moduleKey,
                    'role_name' => $role?->name ?? 'Sin Rol',
                    'role_id' => $role?->id,
                    'last_heartbeat_at' => now(),
                ]);
            }
        }

        if ($activity) {
            $request->attributes->set('visit_activity_id', $activity->id);
            $request->attributes->set('visit_module_key', $moduleKey);
        }

        return $next($request);
    }
}
