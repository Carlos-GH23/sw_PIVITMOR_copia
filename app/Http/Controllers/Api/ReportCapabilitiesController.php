<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ReportFiltersDTO;
use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportCapabilitiesService;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use Illuminate\Http\Request;

class ReportCapabilitiesController extends Controller
{
    use ApiResponse, Filterable;

    public function __construct(protected ReportCapabilitiesService $capabilitiesService) {}

    public function index(Request $request)
    {
        $filtersDTO = ReportFiltersDTO::fromRequest($request->all());
        $tableFilters = $this->getFiltersBase($request->all());

        return $this->success([
            'filters' => $tableFilters,
            'oecdStackedBar' => $this->capabilitiesService->getOecdStackedBarChart($filtersDTO),
            'isicPie' => $this->capabilitiesService->getIsicPieChart($filtersDTO),
            'publicationTimes' => $this->capabilitiesService->getPublicationTimesLineChart($filtersDTO),
            'publicationsTable' => $this->capabilitiesService->getPublicationsTablePaginated($filtersDTO, $tableFilters),
        ]);
    }
}
