<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreTechnologyServiceTypeRequest;
use App\Http\Resources\Catalogs\TechnologyServiceTypeResource;
use App\Models\Catalogs\TechnologyServiceType;
use App\Traits\Filterable;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class TechnologyServiceTypeController extends Controller
{
    use Filterable, HasOrderableRelations;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "technologyServiceTypes.";
        $this->source    = "Core/Catalogs/TechnologyServiceType/";
        $this->model     = new TechnologyServiceType();
    $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
    $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
    $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
    $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->model
            ->with('category')
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('code', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('category', 'name', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);
        $serviceTypes = $query->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'       => 'Catálogo de tipos de servicio tecnológico',
            'serviceTypes'=> TechnologyServiceTypeResource::collection($serviceTypes),
            'routeName'   => $this->routeName,
            'filters'     => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Catalogs\TechnologyServiceCategory::orderBy('name')->get();
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar tipo de servicio tecnológico',
            'routeName' => $this->routeName,
            'categories' => \App\Http\Resources\Catalogs\TechnologyServiceCategoryResource::collection($categories),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTechnologyServiceTypeRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de servicio tecnológico creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnologyServiceType $technologyServiceType)
    {
        $categories = \App\Models\Catalogs\TechnologyServiceCategory::orderBy('name')->get();
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar tipo de servicio tecnológico',
            'routeName'     => $this->routeName,
            'serviceType'   => new TechnologyServiceTypeResource($technologyServiceType),
            'categories'    => \App\Http\Resources\Catalogs\TechnologyServiceCategoryResource::collection($categories),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\Catalogs\UpdateTechnologyServiceTypeRequest $request, TechnologyServiceType $technologyServiceType)
    {
        $technologyServiceType->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de servicio tecnológico modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnologyServiceType $technologyServiceType)
    {
        $technologyServiceType->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de servicio tecnológico eliminado con éxito');
    }

        public function getOrderableRelations(): array
    {
        return [
            'category' => ['technology_service_categories', 'category_id', 'name'],
        ];
    }
}
