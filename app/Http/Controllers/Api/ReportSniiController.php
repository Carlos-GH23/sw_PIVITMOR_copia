<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ReportFiltersDTO;
use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportSniiService;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use Illuminate\Http\Request;

class ReportSniiController extends Controller
{
    use ApiResponse, Filterable;

    public function __construct(protected ReportSniiService $sniiService) {}

    public function index(Request $request)
    {
        $filtersDTO = ReportFiltersDTO::fromRequest($request->all());
        $tableFilters = $this->getFiltersBase($request->all());

        return $this->success([
            'filters' => $tableFilters,
            'kpis' => $this->sniiService->getKpis($filtersDTO),
            'charts' => $this->sniiService->getCharts($filtersDTO),
            'funnelChart' => $this->sniiService->getContributionFunnel($filtersDTO),
            'levelsTable' => $this->sniiService->getAbstractTablePaginated($filtersDTO, $tableFilters),
        ]);
    }
}
