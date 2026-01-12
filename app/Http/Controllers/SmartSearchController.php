<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmartSearchService;
use App\Models\Capability;
use App\Traits\Filterable;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;

class SmartSearchController extends Controller
{
    use Filterable;

    protected SmartSearchService $smartSearchService;
    protected string $routeName;
    protected string $source;

    public function __construct(SmartSearchService $smartSearchService)
    {
        $this->smartSearchService = $smartSearchService;
        $this->routeName = "buscador-inteligente";
        $this->source = "Interface/Welcome/Pages/";
    }

    public function index(Request $request)
    {
        $filters = (object) array_merge(
            (array) $this->getFiltersBase($request->query()),
            [
                'page' => $request->query('page', 1),
                'rows' => $request->query('rows', 8),
                'social_sector' => $request->query('social_sector', null)
            ]
        );

        $capabilities = $this->smartSearchService->performCapabilitySearch($filters, $request);

        return Inertia::render("{$this->source}SmartSearch", [
            'title'        => 'Buscador inteligente',
            'routeName'    => $this->routeName,
            'capabilities' => JsonResource::collection($capabilities),
            'filters'      => $filters,
        ]);
    }
}
