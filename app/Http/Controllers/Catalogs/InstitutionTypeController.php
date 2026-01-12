<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreInstitutionTypeRequest;
use App\Http\Requests\Catalogs\UpdateInstitutionTypeRequest;
use App\Http\Resources\Catalogs\InstitutionTypeResource;
use App\Models\Catalogs\InstitutionType;
use App\Models\Institution\InstitutionCategory;
use App\Traits\Filterable;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class InstitutionTypeController extends Controller
{
    use Filterable, HasOrderableRelations;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "institutionTypes.";
        $this->source    = "Core/Catalogs/InstitutionType/";
        $this->model     = new InstitutionType();
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
            ->with('institutionCategory')
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('code', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('institutionCategory', 'name', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $institutionTypes = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'            => 'Catálogo de tipos de institución',
            'institutionTypes' => InstitutionTypeResource::collection($institutionTypes),
            'routeName'        => $this->routeName,
            'filters'          => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar tipo de institución',
            'routeName' => $this->routeName,
            'institutionCategories' => InstitutionCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstitutionTypeRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de institución creado con éxito');
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
    public function edit(InstitutionType $institutionType)
    {
        $institutionType->load('institutionCategory');
        return Inertia::render("{$this->source}Edit", [
            'title'          => 'Editar tipo de institución',
            'routeName'      => $this->routeName,
            'institutionType' => new InstitutionTypeResource($institutionType),
            'institutionCategories' => InstitutionCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitutionTypeRequest $request, InstitutionType $institutionType)
    {
        $institutionType->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de institución modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstitutionType $institutionType)
    {
        $institutionType->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de institución eliminado con éxito');
    }

    public function getOrderableRelations(): array
    {
        return [
            'institution_category' => ['institution_categories', 'institution_category_id', 'code'],
        ];
    }
}
