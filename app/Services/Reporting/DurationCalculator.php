<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DurationCalculator
{
    private int $maxSeconds;
    private int $minSeconds;

    public function __construct()
    {
        $this->maxSeconds = config('reporting.duration.max_session_seconds');
        $this->minSeconds = config('reporting.duration.min_session_seconds');
    }

    public function calculate(ReportFiltersDTO $filters, array $moduleKeys): array
    {
        $results = $this->fromHeartbeats($filters, $moduleKeys);

        if ($results->isEmpty()) {
            $results = $this->fromWindowFunction($filters, $moduleKeys);
        }

        return $this->format($results, $moduleKeys);
    }

    private function fromHeartbeats(ReportFiltersDTO $filters, array $moduleKeys): Collection
    {
        return Activity::query()
            ->select('module_key')
            ->selectRaw('AVG(duration_seconds) as avg_duration')
            ->where('log_name', 'system_module_visit')
            ->whereIn('module_key', $moduleKeys)
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate])
            ->whereNotNull('duration_seconds')
            ->where('duration_seconds', '>', 0)
            ->when($filters->userTypeId, fn($q) => $q->where('role_id', $filters->userTypeId))
            ->groupBy('module_key')
            ->get();
    }

    private function fromWindowFunction(ReportFiltersDTO $filters, array $moduleKeys): Collection
    {
        $placeholders = implode(',', array_fill(0, count($moduleKeys), '?'));
        $tableName = app(Activity::class)->getTable();

        $sql = "
            WITH visit_durations AS (
                SELECT 
                    module_key,
                    TIMESTAMPDIFF(
                        SECOND, created_at,
                        LEAD(created_at) OVER (PARTITION BY causer_id ORDER BY created_at)
                    ) as duration_seconds
                FROM {$tableName}
                WHERE log_name = 'system_module_visit'
                    AND module_key IN ({$placeholders})
                    AND created_at BETWEEN ? AND ?
                    AND causer_id IS NOT NULL
            )
            SELECT module_key, AVG(duration_seconds) as avg_duration
            FROM visit_durations
            WHERE duration_seconds BETWEEN ? AND ?
            GROUP BY module_key
        ";

        $bindings = [
            ...$moduleKeys,
            $filters->startDate->toDateTimeString(),
            $filters->endDate->toDateTimeString(),
            $this->minSeconds,
            $this->maxSeconds,
        ];

        try {
            return collect(DB::select($sql, $bindings));
        } catch (Exception $e) {
            return collect();
        }
    }

    private function format(Collection $results, array $moduleKeys): array
    {
        $durations = $results->mapWithKeys(function ($item) {
            $item = (object) $item;
            return [$item->module_key => $this->formatSeconds((float) $item->avg_duration)];
        })->toArray();

        foreach ($moduleKeys as $key) {
            $durations[$key] ??= 'N/A';
        }

        return $durations;
    }

    private function formatSeconds(float $seconds): string
    {
        if ($seconds <= 0) return 'N/A';

        $minutes = round($seconds / 60);

        if ($minutes < 1) return '< 1 min';
        if ($minutes < 60) return "{$minutes} min";

        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        return $remaining === 0 ? "{$hours}h" : "{$hours}h {$remaining}m";
    }
}
