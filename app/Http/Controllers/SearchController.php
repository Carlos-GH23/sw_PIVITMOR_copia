<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Institution\SniLevel;
use App\Models\Municipality;
use App\Models\ResearchArea;
use App\Services\SearchService;
use App\Traits\Filterable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->routeName = "searches";
        $this->source    = "Shared/Searches/Pages/";
        $this->searchService = $searchService;
    }

    public function __invoke(Request $request)
    {
        $filters = $this->getSearchFilters($request->query());
        $results = $this->searchService->performUnifiedSearch($filters, $request);

        return Inertia::render("{$this->source}Search", [
            'title'     => 'Búsquedas avanzadas',
            'routeName' => $this->routeName,
            'filters'   => $filters,
            'results'   => $results,
            'intellectualProperties' => IntellectualProperty::select('id', 'name')->orderBy('name')->get(),
            'economicSectors' => EconomicSector::select('id', 'name')->orderBy('name')->isParent()->get(),
            'municipalities' => Municipality::select('id', 'name')->orderBy('name')->where('state_id', 17)->get(),
            'oecdSectors' => OecdSector::select('id', 'name')->isParent()->orderBy('name')->get(),
            'researchAreas' => ResearchArea::select('id', 'name')->orderBy('order')->get(),
            'sniLevels' => SniLevel::select('id', 'name')->orderBy('name')->get(),
            'techLevels' => TechnologyLevel::select('id', 'level', 'name')->orderBy('name')->get(),
        ]);
    }
}
