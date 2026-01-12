<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\ReportFiltersDTO;
use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Institution\InstitutionCategory;
use App\Models\Institution\SniLevel;
use App\Models\Municipality;
use App\Models\ResearchArea;
use App\Services\Reporting\ReportKpiService;
use App\Traits\Filterable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class ReportController extends Controller
{
    use Filterable;

    private string $routeName = 'reports.';
    private string $source = 'Interface/Reports/Pages/';

    public function __construct(protected ReportKpiService $kpiService)
    {
        $this->middleware("permission:reports")->only('index');
    }

    public function index(Request $request): Response
    {
        $rawFilters = $this->getFiltersReport($request->query());
        $filtersDTO = ReportFiltersDTO::fromRequest((array) $rawFilters);

        return Inertia::render("{$this->source}Index", [
            'title' => 'Gestión de reportes',
            'routeName' => $this->routeName,
            'filtersReport' => $rawFilters,
            'userTypes' => Role::select('id', 'name')->where('name', '!=', 'Admin')->get(),
            'oecdSectors' => OecdSector::whereNull('parent_id')->orderBy('name')->select('id', 'name')->get(),
            'economicSectors' => EconomicSector::whereNull('parent_id')->orderBy('name')->select('id', 'name')->get(),
            'categories'    => InstitutionCategory::orderBy('name')->select('id', 'name')->get(),
            'researchAreas' => ResearchArea::select('id', 'name')->orderBy('name')->get(),
            'sniLevels' => SniLevel::select('id', 'name')->orderBy('name')->get(),
            'genders'   => Gender::toSelectArray(),
            'municipalities' => Municipality::select('id', 'name')->orderBy('name')->where('state_id', 17)->get(),
            'kpisData' => $this->kpiService->getKpis($filtersDTO),
        ]);
    }
}
