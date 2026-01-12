<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Requests\Catalogs\UpdateEquipmentTypeRequest;
use App\Http\Requests\Catalogs\StoreEquipmentTypeRequest;
use App\Http\Resources\Catalogs\EquipmentTypeResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\EquipmentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Filterable;
use Inertia\Inertia;

class EquipmentTypeController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "equipmentTypes.";
        $this->source    = "Core/Catalogs/EquipmentType/";
        $this->model     = new EquipmentType();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->model->query()->when($filters->search, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        });

        $equipmentTypes = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'           => 'Catálogo tipo de infraestructura tecnológica',
            'routeName'       => $this->routeName,
            'filters'         => $filters,
            'equipmentTypes' => EquipmentTypeResource::collection($equipmentTypes)
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'       => 'Agregar tipo de infraestructura tecnológica',
            'routeName'   => $this->routeName,
        ]);
    }

    public function store(StoreEquipmentTypeRequest $request)
    {
        $this->model->create($request->validated());

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de infraestructura tecnológica creado exitosamente.');
    }


    public function edit(EquipmentType $equipmentType)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'       => 'Editar tipo de infraestructura tecnológica',
            'routeName'   => $this->routeName,
            'equipmentType' => $equipmentType,
        ]);
    }

    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType)
    {
        $equipmentType->update($request->validated());

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de infraestructura tecnológica actualizado exitosamente.');
    }

    public function destroy(EquipmentType $equipmentType)
    {
        $equipmentType->delete();

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de infraestructura tecnológica eliminado exitosamente.');
    }
}
