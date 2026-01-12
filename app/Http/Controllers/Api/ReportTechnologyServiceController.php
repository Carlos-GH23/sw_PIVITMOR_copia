<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ReportFiltersDTO;
use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportTechnologyServiceService;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use Illuminate\Http\Request;

class ReportTechnologyServiceController extends Controller
{
    use ApiResponse, Filterable;

    public function __construct(protected ReportTechnologyServiceService $techService) {}

    public function index(Request $request)
    {
        $filtersDTO = ReportFiltersDTO::fromRequest($request->all());
        $tableFilters = $this->getFiltersBase($request->all());

        return $this->success([
            'filters' => $tableFilters,
            'oecdStackedBar' => $this->techService->getOecdStackedBarChart($filtersDTO),
            'isicPie' => $this->techService->getIsicPieChart($filtersDTO),
            'publicationTimes' => $this->techService->getPublicationTimesLineChart($filtersDTO),
            'servicesTable' => $this->techService->getServicesTablePaginated($filtersDTO, $tableFilters),
        ]);
    }
}
