<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ReportFiltersDTO;
use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportInstitutionalPerformanceService;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use Illuminate\Http\Request;

class InstitutionalPerformanceController extends Controller
{
    use ApiResponse, Filterable;

    public function __construct(protected ReportInstitutionalPerformanceService $institutionalService) {}

    public function index(Request $request)
    {
        $filtersDTO = ReportFiltersDTO::fromRequest($request->all());
        $tableFilters = $this->getFiltersBase($request->all());

        return $this->success([
            'filters' => $tableFilters,
            'activeInstitutionsChart' => $this->institutionalService->getMostActiveInstitutions($filtersDTO),
            'governmentAgenciesChart' => $this->institutionalService->getGovernmentAgenciesParticipation($filtersDTO),
            'matchesTable' => $this->institutionalService->getMatchesTablePaginated($filtersDTO, $tableFilters),
        ]);
    }
}
