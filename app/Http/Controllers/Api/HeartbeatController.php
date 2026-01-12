<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HeartbeatController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'activity_id' => 'required|integer',
            'module_key' => 'required|string|max:50',
        ]);

        if (!Auth::check()) {
            return $this->error('No autorizado', 401);
        }

        $activityId = $validated['activity_id'];
        $moduleKey = $validated['module_key'];
        $userId = Auth::id();
        $now = now();

        $maxDuration = config('reporting.duration.max_session_seconds', 1800);
        $heartbeatInterval = config('reporting.duration.heartbeat_interval', 5);
        $maxGapBetweenHeartbeats = $heartbeatInterval + 10;

        $activity = DB::table('activity_log')
            ->where('id', $activityId)
            ->where('causer_id', $userId)
            ->where('module_key', $moduleKey)
            ->where('log_name', 'system_module_visit')
            ->first();

        if (!$activity) {
            return $this->error('Actividad no encontrada', 404);
        }

        $lastHeartbeat = $activity->last_heartbeat_at
            ? Carbon::parse($activity->last_heartbeat_at)
            : Carbon::parse($activity->created_at);

        $secondsSinceLastHeartbeat = $lastHeartbeat->diffInSeconds($now);
        $currentDuration = $activity->duration_seconds ?? 0;

        if ($secondsSinceLastHeartbeat <= $maxGapBetweenHeartbeats) {
            $newDuration = min($currentDuration + $secondsSinceLastHeartbeat, $maxDuration);
        } else {
            $newDuration = $currentDuration;
        }

        $updated = DB::table('activity_log')
            ->where('id', $activityId)
            ->update(['last_heartbeat_at' => $now, 'duration_seconds' => $newDuration]);

        return $this->success($updated);
    }
}
