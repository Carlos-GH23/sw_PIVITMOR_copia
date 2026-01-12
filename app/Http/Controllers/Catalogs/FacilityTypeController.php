<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\FacilityType;
use App\Http\Resources\Catalogs\FacilityTypeResource;
use App\Http\Requests\Catalogs\UpdateFacilityTypeRequest;
use App\Http\Requests\Catalogs\StoreFacilityTypeRequest;
use Inertia\Inertia;

class FacilityTypeController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "facilityTypes.";
        $this->source    = "Core/Catalogs/FacilityType/";
        $this->model     = new FacilityType();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

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

        $facilityTypes = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'          => 'Catálogo de tipos de instalación especializada',
            'facilityTypes'  => FacilityTypeResource::collection($facilityTypes),
            'routeName'      => $this->routeName,
            'filters'        => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar tipo de instalación especializada',
            'routeName' => $this->routeName,
        ]);
    }

    public function store(StoreFacilityTypeRequest $request)
    {

        $this->model->create($request->validated());

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de instalación agregado exitosamente.');
    }

    public function edit(FacilityType $facilityType)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar tipode instalación especializada',
            'routeName'     => $this->routeName,
            'facilityType'  => $facilityType
        ]);
    }

    public function update(UpdateFacilityTypeRequest $request, FacilityType $facilityType)
    {
        $facilityType->update($request->validated());

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de instalación actualizado exitosamente.');
    }

    public function destroy(FacilityType $facilityType)
    {
        $facilityType->delete();

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de instalación eliminado exitosamente.');
    }
}
