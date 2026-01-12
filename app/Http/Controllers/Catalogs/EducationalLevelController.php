<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Institution\EducationalLevelResource;
use App\Http\Requests\Catalogs\StoreEducationalLevelRequest;
use App\Http\Requests\Catalogs\UpdateEducationalLevelRequest;
use App\Models\AcademicOfferings\EducationalLevel;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationalLevelController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/EducationalLevel/';
        $this->model = new EducationalLevel();
        $this->routeName = 'educationalLevels.';

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
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $educationalLevels = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de niveles educativos',
            'educationalLevels' => EducationalLevelResource::collection($educationalLevels),
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
            'title'     => 'Agregar nivel educativo',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationalLevelRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Nivel educativo creado con éxito');
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
    public function edit(EducationalLevel $educationalLevel)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar nivel educativo',
            'routeName'         => $this->routeName,
            'educationalLevel'  => new EducationalLevelResource($educationalLevel),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationalLevelRequest $request, EducationalLevel $educationalLevel)
    {
        $educationalLevel->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Nivel educativo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationalLevel $educationalLevel)
    {
        $educationalLevel->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Nivel educativo eliminado con éxito');
    }
}
