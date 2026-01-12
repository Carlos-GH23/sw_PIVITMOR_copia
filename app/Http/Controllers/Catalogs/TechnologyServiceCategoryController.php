<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreTechnologyServiceCategoryRequest;
use App\Http\Requests\Catalogs\UpdateTechnologyServiceCategoryRequest;
use App\Http\Resources\Catalogs\TechnologyServiceCategoryResource;
use App\Models\Catalogs\TechnologyServiceCategory;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class TechnologyServiceCategoryController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "technologyServiceCategories.";
        $this->source    = "Core/Catalogs/TechnologyServiceCategory/";
        $this->model     = new TechnologyServiceCategory();
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
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('code', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $serviceCategories = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'       => 'Catálogo de categorías de servicio tecnológico',
            'serviceCategories'=> TechnologyServiceCategoryResource::collection($serviceCategories),
            'routeName'   => $this->routeName,
            'filters'     => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar categoría de servicio',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTechnologyServiceCategoryRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Categoría de servicio tecnológico creada con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnologyServiceCategory $technologyServiceCategory)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar categoría de servicio tecnológico',
            'routeName'     => $this->routeName,
            'serviceCategory'   => new TechnologyServiceCategoryResource($technologyServiceCategory),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTechnologyServiceCategoryRequest $request, TechnologyServiceCategory $technologyServiceCategory)
    {
        $technologyServiceCategory->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Categoría de servicio tecnológico modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnologyServiceCategory $technologyServiceCategory)
    {
        $technologyServiceCategory->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Categoría de servicio tecnológico eliminada con éxito');
    }
}
