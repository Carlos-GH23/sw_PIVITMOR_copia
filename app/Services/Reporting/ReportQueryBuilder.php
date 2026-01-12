<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportQueryBuilder
{
    private int $publishedStatusId = 3;

    private function getStatusColumn(Model $model): string
    {
        return Str::singular($model->getTable()) . '_status_id';
    }

    public function countBySector(Model $model, string $sectorType, ReportFiltersDTO $filters): Collection
    {
        $relationName = $sectorType === 'oecd' ? 'oecdSectors' : 'economicSectors';
        $sectorTable = $sectorType === 'oecd' ? 'oecd_sectors' : 'economic_sectors';

        $pivotTable = $model->$relationName()->getTable();
        $relatedKey = $model->$relationName()->getRelatedPivotKeyName();
        $foreignKey = $model->$relationName()->getForeignPivotKeyName();
        $modelTable = $model->getTable();

        $query = $model->newQuery();

        $query->status($this->publishedStatusId)
            ->whereBetween("$modelTable.created_at", [$filters->startDate, $filters->endDate])
            ->join($pivotTable, "$modelTable.id", '=', "$pivotTable.$foreignKey")
            ->join($sectorTable, "$sectorTable.id", '=', "$pivotTable.$relatedKey")
            ->select(
                DB::raw("COALESCE($sectorTable.parent_id, $sectorTable.id) as sector_id"),
                DB::raw("COUNT(DISTINCT $pivotTable.$foreignKey) as count")
            )
            ->groupBy(DB::raw("COALESCE($sectorTable.parent_id, $sectorTable.id)"));

        $this->applySectorFilter($query, $sectorTable, $sectorType === 'oecd' ? $filters->oecdSectorId : $filters->economicSectorId);
        return $query->pluck('count', 'sector_id');
    }

    public function viewsByEconomicSector(Model $model, ReportFiltersDTO $filters): Collection
    {
        $pivotTable = $model->economicSectors()->getTable();
        $foreignKey = $model->economicSectors()->getForeignPivotKeyName();
        $relatedKey = $model->economicSectors()->getRelatedPivotKeyName();
        $modelTable = $model->getTable();
        $statusCol = $this->getStatusColumn($model);

        $query = DB::table('views')
            ->where('viewable_type', $model->getMorphClass())
            ->join($modelTable, 'views.viewable_id', '=', "$modelTable.id")
            ->join($pivotTable, "$modelTable.id", '=', "$pivotTable.$foreignKey")
            ->join('economic_sectors', 'economic_sectors.id', '=', "$pivotTable.$relatedKey")
            ->where("$modelTable.$statusCol", $this->publishedStatusId)
            ->whereNull("$modelTable.deleted_at")
            ->whereBetween('views.viewed_at', [$filters->startDate, $filters->endDate]);

        $this->applySectorFilter($query, 'economic_sectors', $filters->economicSectorId);

        return $query
            ->select(
                DB::raw('COALESCE(economic_sectors.parent_id, economic_sectors.id) as sector_id'),
                DB::raw('COUNT(DISTINCT views.id) as count')
            )
            ->groupBy(DB::raw('COALESCE(economic_sectors.parent_id, economic_sectors.id)'))
            ->pluck('count', 'sector_id');
    }

    public function publicationTimesByMonth(Model $model, ReportFiltersDTO $filters): Collection
    {
        $statusCol = $this->getStatusColumn($model);

        $query = $model->newQuery()->where($statusCol, $this->publishedStatusId)
            ->whereNotNull('published_at')->whereBetween('created_at', [$filters->startDate, $filters->endDate]);

        if ($filters->oecdSectorId) {
            $query->whereHas('oecdSectors', fn($q) => $this->applySectorFilter($q, 'oecd_sectors', $filters->oecdSectorId));
        }

        if ($filters->economicSectorId) {
            $query->whereHas('economicSectors', fn($q) => $this->applySectorFilter($q, 'economic_sectors', $filters->economicSectorId));
        }

        return $query
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('ROUND(AVG(TIMESTAMPDIFF(DAY, created_at, published_at)), 1) as avg_days')
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->pluck('avg_days', 'month');
    }

    private function applySectorFilter($query, string $table, ?int $filterId): void
    {
        if ($filterId) {
            $query->where(function ($q) use ($table, $filterId) {
                $q->where("$table.id", $filterId)->orWhere("$table.parent_id", $filterId);
            });
        }
    }

    public function forType(Model $model, ReportFiltersDTO $filters): Builder
    {
        return $model->newQuery()
            ->where($this->getStatusColumn($model), $this->publishedStatusId)
            ->whereBetween('created_at', [$filters->startDate, $filters->endDate]);
    }
}
