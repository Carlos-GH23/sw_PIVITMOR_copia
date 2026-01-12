<?php

namespace App\Traits;

use App\DTOs\ReportFiltersDTO;
use Illuminate\Database\Eloquent\Builder;

trait HasReportFilters
{
    public function scopeApplyReportFilters(Builder $query, ReportFiltersDTO $filters): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->when($filters->startDate, fn($q) => $q->where('created_at', '>=', $filters->startDate))
            ->when($filters->endDate, fn($q) => $q->where('created_at', '<=', $filters->endDate))
            ->when($filters->oecdSectorId, function ($q) use ($filters) {
                $q->whereHas('oecdSectors', function ($subQuery) use ($filters) {
                    $subQuery->where('oecd_sectors.id', $filters->oecdSectorId)
                        ->orWhere('oecd_sectors.parent_id', $filters->oecdSectorId);
                });
            })
            ->when($filters->economicSectorId, function ($q) use ($filters) {
                $q->whereHas('economicSectors', function ($subQuery) use ($filters) {
                    $subQuery->where('economic_sectors.id', $filters->economicSectorId)
                        ->orWhere('economic_sectors.parent_id', $filters->economicSectorId);
                });
            });
    }
}
