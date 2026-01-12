<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreKnowledgeAreaRequest;
use App\Http\Requests\Catalogs\UpdateKnowledgeAreaRequest;
use App\Models\Catalogs\KnowledgeArea;
use App\Http\Resources\Catalogs\KnowledgeAreaResource;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class KnowledgeAreaController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/KnowledgeArea/';
        $this->model = new KnowledgeArea();
        $this->routeName = 'knowledgeAreas.';

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
        $query = $this->model->query()->when($filters->search, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->with('parent');

        $knowledgeAreas = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'knowledge_areas'   => KnowledgeAreaResource::collection($knowledgeAreas),
            'title'             => 'Catálogo de áreas de conocimiento',
            'routeName'         => $this->routeName,
            'filters'           => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = KnowledgeArea::whereNull('parent_id')->orderBy('name')->get(['id', 'name']);
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar área de conocimiento',
            'routeName' => $this->routeName,
            'parentAreas' => $parents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKnowledgeAreaRequest $request)
    {
        KnowledgeArea::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Área de conocimiento creada con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowledgeArea $knowledgeArea)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowledgeArea $knowledgeArea)
    {
        $parents = KnowledgeArea::whereNull('parent_id')->where('id', '!=', $knowledgeArea->id)->orderBy('name')->get(['id', 'name']);
        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar área de conocimiento',
            'routeName'         => $this->routeName,
            'area'              => $knowledgeArea,
            'parentAreas'       => $parents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowledgeAreaRequest $request, KnowledgeArea $knowledgeArea)
    {
        $knowledgeArea->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Área de conocimiento actualizada con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnowledgeArea $knowledgeArea)
    {
        $knowledgeArea->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Área de conocimiento eliminada con éxito');
    }
}
