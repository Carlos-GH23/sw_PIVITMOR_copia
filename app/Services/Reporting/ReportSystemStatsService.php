<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Illuminate\Support\Facades\DB;

class ReportSystemStatsService
{
    private array $modules;
    private array $roles;

    public function __construct(private DurationCalculator $durationCalculator, private ChartDataBuilder $chartBuilder)
    {
        $this->modules = config('reporting.modules');
        $this->roles = config('reporting.roles');
    }

    public function getActivityLineChart(ReportFiltersDTO $filters): array
    {
        $datasets = [];
        $labels = [];

        foreach ($this->roles as $dbRoleName => $config) {
            $trend = Trend::query(ActivityQueryBuilder::forLogins($filters, $dbRoleName))
                ->between(start: $filters->startDate, end: $filters->endDate)->perMonth()->count();

            if (empty($labels)) {
                $labels = $trend->map(fn($item) => Carbon::parse($item->date)->translatedFormat('M Y'))->toArray();
            }

            $datasets[] = $this->chartBuilder->lineDataset(
                $config['label'],
                $trend->pluck('aggregate')->toArray(),
                $config['color'],
                ['borderWidth' => 2, 'pointRadius' => 3, 'pointHoverRadius' => 5]
            );
        }

        return $this->chartBuilder->chartResponse($labels, $datasets);
    }

    public function getSessionsByRoleChart(ReportFiltersDTO $filters): array
    {
        $moduleKeys = array_keys($this->modules);
        $roleNames = array_keys($this->roles);

        $rawData = ActivityQueryBuilder::forModuleVisits($filters, $moduleKeys)
            ->select('role_name', 'module_key', DB::raw('COUNT(*) as total'))
            ->groupBy('role_name', 'module_key')
            ->get()->groupBy('module_key');

        $datasets = [];

        foreach ($this->modules as $moduleKey => $moduleConfig) {
            $moduleData = $rawData->get($moduleKey, collect());

            if ($moduleData->isEmpty()) continue;

            $datasets[] = $this->chartBuilder->barDataset(
                $moduleConfig['name'],
                collect($roleNames)->map(fn($role) => $moduleData->firstWhere('role_name', $role)?->total ?? 0)->toArray(),
                $moduleConfig['color'],
                ['borderRadius' => 4]
            );
        }

        $labels = collect($roleNames)->map(fn($role) => $this->roles[$role]['label'] ?? $role)->toArray();
        return $this->chartBuilder->chartResponse($labels, $datasets);
    }

    public function getModuleStatsTable(ReportFiltersDTO $filters): array
    {
        $moduleKeys = array_keys($this->modules);
        $moduleStats = $this->getModuleVisitStats($filters, $moduleKeys);
        $durations = $this->durationCalculator->calculate($filters, $moduleKeys);

        return collect($this->modules)->map(function ($config, $key) use ($moduleStats, $durations) {
            $stats = $moduleStats->get($key, collect());
            $topRole = $stats->sortByDesc('visits')->first();

            return [
                'name' => $config['name'],
                'key' => $key,
                'visits' => $stats->sum('visits'),
                'users' => $topRole ? [$this->roles[$topRole->role_name]['label'] ?? $topRole->role_name] : ['N/A'],
                'average_duration' => $durations[$key],
            ];
        })->values()->toArray();
    }

    private function getModuleVisitStats(ReportFiltersDTO $filters, array $moduleKeys)
    {
        return ActivityQueryBuilder::forModuleVisits($filters, $moduleKeys)
            ->select('module_key', 'role_name', DB::raw('COUNT(*) as visits'))
            ->groupBy('module_key', 'role_name')->get()->groupBy('module_key');
    }
}
