<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreResearchAreaRequest;
use App\Http\Requests\Catalogs\UpdateResearchAreaRequest;
use App\Http\Resources\Institution\ResearchAreaResource;
use App\Models\ResearchArea;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchAreaController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/ResearchArea/';
        $this->model = new ResearchArea();
        $this->routeName = 'researchAreas.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

        $researchAreas = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de áreas SNII',
            'researchAreas'     => ResearchAreaResource::collection($researchAreas),
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
            'title'     => 'Agregar área SNII',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResearchAreaRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Área creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResearchArea $researchArea)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar área SNII',
            'routeName'     => $this->routeName,
            'researchArea'  => new ResearchAreaResource($researchArea),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResearchAreaRequest $request, ResearchArea $researchArea)
    {
        $researchArea->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Área actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResearchArea $researchArea)
    {
        $researchArea->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Área eliminada con éxito");
    }
}
