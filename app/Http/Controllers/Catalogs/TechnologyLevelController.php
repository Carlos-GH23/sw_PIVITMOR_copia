<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreTechnologyLevelRequest;
use App\Http\Requests\Catalogs\UpdateTechnologyLevelRequest;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\TechnologyLevel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Catalogs\TechnologyLevelResource;
use Illuminate\Contracts\Cache\Store;

class TechnologyLevelController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "technologyLevels.";
        $this->source    = "Core/Catalogs/TLR/";
        $this->model     = new TechnologyLevel();

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
                ->orWhere('level', 'LIKE', '%' . $search . '%');
        });

        $technology_levels = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'technology_levels' => TechnologyLevelResource::collection($technology_levels),
            'title'           => 'Catálogo TLR',
            'routeName'       => $this->routeName,
            'filters'         => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar TLR',
            'routeName' => $this->routeName,
            'form'      => $this->model
        ]);
    }

    public function store(StoreTechnologyLevelRequest $request)
    {
        TechnologyLevel::create($request->validated());

        return redirect()->route("{$this->routeName}index")->with('success', 'TLR agregado con éxito.');
    }

    public function edit(TechnologyLevel $technologyLevel)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'      => 'Editar TLR',
            'routeName'  => $this->routeName,
            'technology_level'       => $technologyLevel
        ]);
    }

    public function update(UpdateTechnologyLevelRequest $request, TechnologyLevel $technologyLevel)
    {
        $technologyLevel->update($request->validated());

        return redirect()->route("{$this->routeName}index")->with('success', 'TLR actualizado con éxito.');
    }

    public function destroy(TechnologyLevel $technologyLevel)
    {
        $technologyLevel->delete();

        return redirect()->route("{$this->routeName}index")->with('success', 'TLR eliminado con éxito.');
    }
}
