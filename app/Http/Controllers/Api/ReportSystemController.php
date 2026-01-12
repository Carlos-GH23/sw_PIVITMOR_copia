<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ReportFiltersDTO;
use App\Http\Controllers\Controller;
use App\Services\Reporting\ReportSystemStatsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReportSystemController extends Controller
{
    use ApiResponse;

    public function __construct(protected ReportSystemStatsService $systemStatsService) {}

    public function index(Request $request)
    {
        $filtersDTO = ReportFiltersDTO::fromRequest($request->all());

        $data = [
            'activityLine' => $this->systemStatsService->getActivityLineChart($filtersDTO),
            'sessionsBar' => $this->systemStatsService->getSessionsByRoleChart($filtersDTO),
            'modulesTable' => $this->systemStatsService->getModuleStatsTable($filtersDTO),
        ];

        return $this->success($data);
    }
}
