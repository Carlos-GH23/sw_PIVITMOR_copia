<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\SocialSector;
use App\Http\Resources\Catalogs\SocialSectorResource;
use App\Http\Requests\Catalogs\StoreSocialSectorRequest;
use App\Http\Requests\Catalogs\UpdateSocialSectorRequest;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SocialSectorController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/SocialSector/';
        $this->model = new SocialSector();
        $this->routeName = 'socialSectors.';

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

        $socialSectors = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de sectores sociales',
            'socialSectors'    => SocialSectorResource::collection($socialSectors),
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
            'title'     => 'Agregar sector social',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialSectorRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector social creado con éxito');
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
    public function edit(SocialSector $socialSector)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar sector social',
            'routeName'     => $this->routeName,
            'socialSector'  => new SocialSectorResource($socialSector),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialSectorRequest $request, SocialSector $socialSector)
    {
        $socialSector->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector social actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialSector $socialSector)
    {
        $socialSector->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Sector social eliminado con éxito");
    }
}
