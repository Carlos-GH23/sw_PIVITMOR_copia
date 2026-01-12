<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\GovernmentSector;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Catalogs\GovernmentSectorResource;
use App\Http\Requests\Catalogs\StoreGovernmentSectorRequest;
use App\Http\Requests\Catalogs\UpdateGovernmentSectorRequest;

class GovernmentSectorController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "governmentSectors.";
        $this->source    = "Core/Catalogs/GovernmentSector/";
        $this->model     = new GovernmentSector();

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

        $governmentSectors = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'governmentSectors' => GovernmentSectorResource::collection($governmentSectors),
            'title'           => 'Catálogo de sectores gubernamentales',
            'routeName'       => $this->routeName,
            'filters'         => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'       => 'Crear sector gubernamental',
            'routeName'   => $this->routeName,
        ]);
    }

    public function store(StoreGovernmentSectorRequest $request)
    {
        try {
            $this->model->create($request->validated());

            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Sector gubernamental creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear el sector gubernamental');
        }
    }

    public function edit(GovernmentSector $governmentSector)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'       => 'Editar sector gubernamental',
            'routeName'   => $this->routeName,
            'governmentSector' => $governmentSector,
        ]);
    }

    public function update(UpdateGovernmentSectorRequest $request, GovernmentSector $governmentSector)
    {
        try {
            $governmentSector->update($request->validated());

            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Sector gubernamental actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al actualizar el sector gubernamental');
        }
    }

    public function destroy(GovernmentSector $governmentSector)
    {
        try {
            $governmentSector->delete();

            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Sector gubernamental eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocurrió un error al eliminar el sector gubernamental');
        }
    }
}
