<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreIntellectualPropertyRequest;
use App\Http\Requests\Catalogs\UpdateIntellectualPropertyRequest;
use App\Http\Resources\Catalogs\IntellectualPropertyResource;
use App\Models\Catalogs\IntellectualProperty;
use App\Traits\Filterable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IntellectualPropertyController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected IntellectualProperty $model;

    public function __construct()
    {
        $this->routeName = "intellectualProperties.";
        $this->source    = "Core/Catalogs/intellectualProperty/";
        $this->model     = new IntellectualProperty();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->model
        ->when($filters->search, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('id', 'LIKE', '%' . $search . '%');
        });

        $query->orderBy($filters->order, $filters->direction);

        $intellectualProperties = $query->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'                  => 'Catálogo de propiedad intelectual',
            'intellectualProperties' => IntellectualPropertyResource::collection($intellectualProperties),
            'routeName'              => $this->routeName,
            'filters'                => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar propiedad intelectual',
            'routeName' => $this->routeName,
        ]);
    }

    public function store(StoreIntellectualPropertyRequest $request)
    {
        IntellectualProperty::create([
            'name' => $request->name,
        ]);

        return redirect()->route('intellectualProperties.index')->with('success', 'Propiedad intelectual creada correctamente.');
    }

    public function edit(IntellectualProperty $intellectualProperty)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'                  => 'Editar propiedad intelectual',
            'routeName'              => $this->routeName,
            'intellectualProperty'   => new IntellectualPropertyResource($intellectualProperty),
        ]);
    }

    public function update(UpdateIntellectualPropertyRequest $request, IntellectualProperty $intellectualProperty)
    {
        $intellectualProperty->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Propiedad intelectual modificada con éxito');
    }

    public function destroy(IntellectualProperty $intellectualProperty)
    {
        $intellectualProperty->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Propiedad intelectual eliminada con éxito');
    }

    public function show(string $id)
    {
        abort(404);
    }
}
