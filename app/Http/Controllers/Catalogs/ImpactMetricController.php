<?php

namespace App\Http\Controllers\Catalogs;

use App\Enums\ImpactMetricType;
use App\Http\Controllers\Controller;
use App\Models\Catalogs\ImpactMetric;
use App\Http\Requests\Catalogs\StoreImpactMetricRequest;
use App\Http\Requests\Catalogs\UpdateImpactMetricRequest;
use App\Http\Resources\Catalogs\ImpactMetricResource;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ImpactMetricController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/ImpactMetric/';
        $this->model = new ImpactMetric();
        $this->routeName = 'impactMetrics.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $query = $this->model->when($filters->search, function ($query, $search) {
            $matchingTypes = ImpactMetricType::valuesMatchingLabel($search);

            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('type', $matchingTypes);
        });

        $categories = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de métricas de impacto',
            'impactMetrics'     => ImpactMetricResource::collection($categories),
            'filters'           => $filters,
            'routeName'         => $this->routeName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar categoría',
            'routeName' => $this->routeName,
            'types' => ImpactMetricType::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImpactMetricRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Métrica de impacto creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(ImpactMetric $impactMetric)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImpactMetric $impactMetric)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar categoría',
            'routeName'     => $this->routeName,
            'impactMetric'  => new ImpactMetricResource($impactMetric),
            'types'         => ImpactMetricType::options(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImpactMetricRequest $request, ImpactMetric $impactMetric)
    {
        $impactMetric->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Métrica de impacto actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImpactMetric $impactMetric)
    {
        $impactMetric->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Métrica de impacto eliminada con éxito");
    }
}
