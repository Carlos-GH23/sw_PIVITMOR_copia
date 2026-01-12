<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ReportFiltersDTO;
use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportMatchService;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use Illuminate\Http\Request;

class ReportMatchController extends Controller
{
    use ApiResponse, Filterable;

    public function __construct(protected ReportMatchService $matchService) {}

    public function index(Request $request)
    {
        $filtersDTO = ReportFiltersDTO::fromRequest($request->all());
        $tableFilters = $this->getFiltersBase($request->all());

        return $this->success([
            'filters' => $tableFilters,
            'funnelChart' => $this->matchService->getFunnelChartData($filtersDTO),
            'matchesTable' => $this->matchService->getMatchesTablePaginated($filtersDTO, $tableFilters),
            'heatmapData' => $this->matchService->getHeatmapData($filtersDTO),
        ]);
    }
}
