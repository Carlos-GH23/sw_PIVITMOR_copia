<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class ActivityQueryBuilder
{
    public static function forModuleVisits(ReportFiltersDTO $filters, ?array $moduleKeys = null): Builder
    {
        $moduleKeys = $moduleKeys ?? array_keys(config('reporting.modules'));

        return Activity::query()
            ->where('log_name', 'system_module_visit')
            ->whereIn('module_key', $moduleKeys)
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate])
            ->when($filters->userTypeId, fn($q) => $q->where('role_id', $filters->userTypeId));
    }

    public static function forLogins(ReportFiltersDTO $filters, ?string $roleName = null): Builder
    {
        return Activity::query()
            ->where('log_name', 'auth')
            ->where('event', 'login')
            ->when($roleName, fn($q) => $q->where('role_name', $roleName));
    }
}
