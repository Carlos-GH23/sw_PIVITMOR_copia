<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreResourceTypeRequest;
use App\Http\Requests\Catalogs\UpdateResourceTypeRequest;
use App\Http\Resources\Catalogs\ResourceTypeResource;
use App\Models\Catalogs\ResourceType;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class ResourceTypeController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "resourceTypes.";
        $this->source    = "Core/Catalogs/ResourceType/";
        $this->model     = new ResourceType();
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
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $resourceTypes = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'         => 'Catálogo de tipos de recursos',
            'resourceTypes' => ResourceTypeResource::collection($resourceTypes),
            'routeName'     => $this->routeName,
            'filters'       => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar tipo de recurso',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceTypeRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de recurso creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResourceType $resourceType)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'        => 'Editar tipo de recurso',
            'routeName'    => $this->routeName,
            'resourceType' => new ResourceTypeResource($resourceType),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceTypeRequest $request, ResourceType $resourceType)
    {
        $resourceType->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de recurso modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResourceType $resourceType)
    {
        $resourceType->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de recurso eliminado con éxito');
    }
}
