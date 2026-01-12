<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Models\Capability;
use App\Models\Requirement;
use App\Models\TechnologyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PublicationQueryBuilder
{
    private int $publishedStatusId;

    public function __construct()
    {
        $this->publishedStatusId = 3;
    }

    private function getModelInstance(string $type): Model
    {
        return match ($type) {
            'capability' => new Capability(),
            'requirement' => new Requirement(),
            'technology_service' => new TechnologyService(),
            default => throw new InvalidArgumentException("Unknown type: {$type}")
        };
    }

    public function forType(string $type, ReportFiltersDTO $filters): Builder
    {
        $query = $this->getModelInstance($type)->newQuery();
        $query->status($this->publishedStatusId)->whereBetween('created_at', [$filters->startDate, $filters->endDate]);
        return $this->applyFilters($query, $filters);
    }

    public function countBySector(string $type, string $sectorType, ReportFiltersDTO $filters): Collection
    {
        $instance = $this->getModelInstance($type);

        $relationName = $sectorType === 'oecd' ? 'oecdSectors' : 'economicSectors';
        $sectorTable = $sectorType === 'oecd' ? 'oecd_sectors' : 'economic_sectors';

        $pivotTable = $instance->$relationName()->getTable();
        $relatedKey = $instance->$relationName()->getRelatedPivotKeyName();
        $foreignKey = $instance->$relationName()->getForeignPivotKeyName();

        $query = $instance->newQuery()
            ->status($this->publishedStatusId)
            ->whereBetween($instance->getTable() . '.created_at', [$filters->startDate, $filters->endDate])
            ->join($pivotTable, $instance->getQualifiedKeyName(), '=', "$pivotTable.$foreignKey")
            ->join($sectorTable, "$sectorTable.id", '=', "$pivotTable.$relatedKey")
            ->select(
                DB::raw("COALESCE($sectorTable.parent_id, $sectorTable.id) as sector_id"),
                DB::raw("COUNT(DISTINCT $pivotTable.$foreignKey) as count")
            )
            ->groupBy(DB::raw("COALESCE($sectorTable.parent_id, $sectorTable.id)"));

        $filterId = $sectorType === 'oecd' ? $filters->oecdSectorId : $filters->economicSectorId;

        if ($filterId) {
            $query->where(function ($q) use ($sectorTable, $filterId) {
                $q->where("$sectorTable.id", $filterId)
                    ->orWhere("$sectorTable.parent_id", $filterId);
            });
        }

        return $query->pluck('count', 'sector_id');
    }

    public function viewsByEconomicSector(ReportFiltersDTO $filters, array $types = ['capability', 'requirement']): Collection
    {
        $results = collect();

        foreach ($types as $type) {
            $instance = $this->getModelInstance($type);
            $pivotTable = $instance->economicSectors()->getTable();
            $foreignKey = $instance->economicSectors()->getForeignPivotKeyName();
            $relatedKey = $instance->economicSectors()->getRelatedPivotKeyName();

            $query = DB::table('views')
                ->where('viewable_type', get_class($instance))
                ->join($instance->getTable(), 'views.viewable_id', '=', $instance->getQualifiedKeyName())
                ->join($pivotTable, $instance->getQualifiedKeyName(), '=', "$pivotTable.$foreignKey")
                ->join('economic_sectors', 'economic_sectors.id', '=', "$pivotTable.$relatedKey")
                ->where($instance->getPublishedStatusField(), $this->publishedStatusId)
                ->whereNull($instance->getTable() . '.deleted_at')
                ->whereBetween('views.viewed_at', [$filters->startDate, $filters->endDate]);

            if ($filters->economicSectorId) {
                $query->where(function ($q) use ($filters) {
                    $q->where('economic_sectors.id', $filters->economicSectorId)
                        ->orWhere('economic_sectors.parent_id', $filters->economicSectorId);
                });
            }

            $data = $query
                ->select(
                    DB::raw('COALESCE(economic_sectors.parent_id, economic_sectors.id) as sector_id'),
                    DB::raw('COUNT(views.id) as count')
                )
                ->groupBy(DB::raw('COALESCE(economic_sectors.parent_id, economic_sectors.id)'))
                ->pluck('count', 'sector_id');

            $results = $results->mergeRecursive($data);
        }

        return $results->map(fn($v) => is_array($v) ? array_sum($v) : $v);
    }

    public function publicationTimesByMonth(string $type, ReportFiltersDTO $filters): Collection
    {
        $instance = $this->getModelInstance($type);

        $query = $instance->newQuery()
            ->status($this->publishedStatusId)
            ->whereNotNull('published_at')
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate]);

        $this->applySectorFilters($query, $filters);

        return $query
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('ROUND(AVG(TIMESTAMPDIFF(DAY, created_at, published_at)), 1) as avg_days')
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->pluck('avg_days', 'month');
    }

    public function applySectorFilters(Builder $query, ReportFiltersDTO $filters): Builder
    {
        if ($filters->oecdSectorId) {
            $query->whereHas('oecdSectors', function ($q) use ($filters) {
                $table = $q->getModel()->getTable();
                $q->where("$table.id", $filters->oecdSectorId)
                    ->orWhere("$table.parent_id", $filters->oecdSectorId);
            });
        }

        if ($filters->economicSectorId) {
            $query->whereHas('economicSectors', function ($q) use ($filters) {
                $table = $q->getModel()->getTable();
                $q->where("$table.id", $filters->economicSectorId)
                    ->orWhere("$table.parent_id", $filters->economicSectorId);
            });
        }

        return $query;
    }

    private function applyFilters(Builder $query, ReportFiltersDTO $filters): Builder
    {
        return $this->applySectorFilters($query, $filters);
    }
}
