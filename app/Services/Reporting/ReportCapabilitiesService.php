<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Models\Capability;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Requirement;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ReportCapabilitiesService
{
    private array $types;
    private array $pieColors;

    public function __construct(private ReportQueryBuilder $queryBuilder, private ChartDataBuilder $chartBuilder)
    {
        $this->types = config('reporting.publications.types');
        $this->pieColors = config('reporting.publications.pie_colors');
    }

    public function getOecdStackedBarChart(ReportFiltersDTO $filters): array
    {
        $sectors = OecdSector::whereNull('parent_id')->orderBy('name')->get();

        return $this->chartBuilder->chartResponse(
            $sectors->pluck('name')->toArray(),
            [
                $this->chartBuilder->stackedBarDataset(
                    $this->types['capability']['label_plural'],
                    $sectors,
                    $this->queryBuilder->countBySector(new Capability(), 'oecd', $filters),
                    $this->types['capability']['color']
                ),
                $this->chartBuilder->stackedBarDataset(
                    $this->types['requirement']['label_plural'],
                    $sectors,
                    $this->queryBuilder->countBySector(new Requirement(), 'oecd', $filters),
                    $this->types['requirement']['color']
                ),
            ]
        );
    }

    public function getIsicPieChart(ReportFiltersDTO $filters): array
    {
        $sectors = EconomicSector::whereNull('parent_id')->orderBy('name')->get();
        $capViews = $this->queryBuilder->viewsByEconomicSector(new Capability(), $filters);
        $reqViews = $this->queryBuilder->viewsByEconomicSector(new Requirement(), $filters);
        $data = $this->chartBuilder->mergeCounts($capViews, $reqViews);

        if ($data->sum() === 0) {
            $capabilities = $this->queryBuilder->countBySector(new Capability(), 'economic', $filters);
            $requirements = $this->queryBuilder->countBySector(new Requirement(), 'economic', $filters);
            $data = $this->chartBuilder->mergeCounts($capabilities, $requirements);
        }

        return $this->chartBuilder->pieChart($sectors, $data, $this->pieColors);
    }

    public function getPublicationTimesLineChart(ReportFiltersDTO $filters): array
    {
        $datasets = [];
        $labels = [];
        $modelMap = ['capability' => Capability::class, 'requirement' => Requirement::class];

        foreach ($this->types as $typeKey => $config) {
            $modelClass = $modelMap[$typeKey];
            $trendData = Trend::query($modelClass::query()->applyReportFilters($filters))
                ->between(start: Carbon::parse($filters->startDate), end: Carbon::parse($filters->endDate))
                ->perMonth()->count();

            if (empty($labels)) {
                $labels = $trendData->map(fn($value) => $value->date)->toArray();
            }

            $datasets[] = $this->chartBuilder->lineDataset(
                $config['label_plural'],
                $trendData->map(fn($value) => $value->aggregate)->toArray(),
                $config['color']
            );
        }

        return $this->chartBuilder->chartResponse($labels, $datasets);
    }

    public function getPublicationsTablePaginated(ReportFiltersDTO $filters, object $tableFilters): LengthAwarePaginator
    {
        $searchColumns = ['title', 'oecdSectors.name', 'economicSectors.name'];

        $search = Search::new()
            ->add(Capability::with(['oecdSectors', 'economicSectors'])->withCount('views')->applyReportFilters($filters), $searchColumns, 'created_at')
            ->add(Requirement::with(['oecdSectors', 'economicSectors'])->withCount('views')->applyReportFilters($filters), $searchColumns, 'created_at')
            ->orderByDesc()
            ->beginWithWildcard()->endWithWildcard()->dontParseTerm()
            ->paginate((int) $tableFilters->rows, 'page', (int) $tableFilters->page)
            ->search($tableFilters->search);

        return $search->through(fn($r) => $this->transformPublication($r));
    }

    private function transformPublication($record): array
    {
        $isCapability = $record instanceof Capability;

        return [
            'id' => $record->id,
            'type_key' => $isCapability ? 'capability' : 'requirement',
            'publication' => $record->title,
            'type' => $isCapability ? 'Capacidad' : 'Necesidad',
            'ocde_area' => $record->oecdSectors->pluck('name')->toArray(),
            'isic_sector' => $record->economicSectors->pluck('name')->toArray(),
            'views' => $record->views_count ?? 0,
            'created_at' => $record->created_at,
        ];
    }
}
