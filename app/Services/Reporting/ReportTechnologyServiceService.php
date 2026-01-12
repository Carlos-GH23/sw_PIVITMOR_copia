<?php

namespace App\Services\Reporting;

use App\DTOs\ReportFiltersDTO;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\TechnologyService;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ReportTechnologyServiceService
{
    private string $color;
    private array $pieColors;

    public function __construct(private ReportQueryBuilder $queryBuilder, private ChartDataBuilder $chartBuilder)
    {
        $this->color = config('reporting.modules.technologyServices.color');
        $this->pieColors = config('reporting.publications.pie_colors');
    }

    public function getOecdStackedBarChart(ReportFiltersDTO $filters): array
    {
        $sectors = OecdSector::whereNull('parent_id')->orderBy('name')->get();
        $counts = $this->queryBuilder->countBySector(new TechnologyService(), 'oecd', $filters);

        return $this->chartBuilder->chartResponse(
            $sectors->pluck('name')->toArray(),
            [
                $this->chartBuilder->barDataset(
                    'Servicios Tecnológicos',
                    $sectors->map(fn($s) => $counts->get($s->id, 0))->toArray(),
                    $this->color
                ),
            ]
        );
    }

    public function getIsicPieChart(ReportFiltersDTO $filters): array
    {
        $sectors = EconomicSector::whereNull('parent_id')->orderBy('name')->get();
        $data = $this->queryBuilder->viewsByEconomicSector(new TechnologyService(), $filters);

        if ($data->sum() === 0) {
            $data = $this->queryBuilder->countBySector(new TechnologyService(), 'economic', $filters);
        }

        return $this->chartBuilder->pieChart($sectors, $data, $this->pieColors);
    }

    public function getPublicationTimesLineChart(ReportFiltersDTO $filters): array
    {
        $query = TechnologyService::query()->applyReportFilters($filters);
        $trendData = Trend::query($query)
            ->between(start: Carbon::parse($filters->startDate), end: Carbon::parse($filters->endDate))->perMonth()->count();

        $labels = $trendData->map(fn($value) => $value->date)->toArray();
        $values = $trendData->map(fn($value) => $value->aggregate)->toArray();

        return $this->chartBuilder->chartResponse(
            $labels,
            [$this->chartBuilder->lineDataset('Servicios Tecnológicos', $values, $this->color)]
        );
    }

    public function getServicesTablePaginated(ReportFiltersDTO $filters, object $tableFilters): LengthAwarePaginator
    {
        $searchColumns = ['title', 'oecdSectors.name', 'economicSectors.name', 'technologyServiceCategory.name'];
        $load = ['oecdSectors', 'economicSectors', 'technologyServiceCategory'];

        $search = Search::new()
            ->add(TechnologyService::with($load)->withCount('views')->applyReportFilters($filters), $searchColumns, 'created_at')
            ->orderByDesc()
            ->beginWithWildcard()->endWithWildcard()->dontParseTerm()
            ->paginate((int) $tableFilters->rows, 'page', (int) $tableFilters->page)
            ->search($tableFilters->search);

        return $search->through(fn($record) => $this->transformService($record));
    }

    private function transformService(TechnologyService $record): array
    {
        return [
            'id' => $record->id,
            'title' => $record->title,
            'category' => $record->technologyServiceCategory?->name,
            'ocde_area' => $record->oecdSectors->pluck('name')->toArray(),
            'isic_sector' => $record->economicSectors->pluck('name')->toArray(),
            'views' => $record->views_count ?? 0,
            'created_at' => $record->created_at,
        ];
    }
}
