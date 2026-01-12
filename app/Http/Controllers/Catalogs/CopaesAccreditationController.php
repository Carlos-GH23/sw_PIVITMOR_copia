<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\AcademicOfferings\CopaesAccreditation;
use App\Http\Resources\Institution\CopaesAccreditationResource;
use App\Http\Requests\Catalogs\StoreCopaesAccreditationRequest;
use App\Http\Requests\Catalogs\UpdateCopaesAccreditationRequest;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CopaesAccreditationController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/CopaesAccreditation/';
        $this->model = new CopaesAccreditation();
        $this->routeName = 'copaesAccreditations.';

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

        $copaesAccreditations = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de acreditaciones COPAES',
            'copaesAccreditations'    => CopaesAccreditationResource::collection($copaesAccreditations),
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
            'title'     => 'Agregar acreditación COPAES',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCopaesAccreditationRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación COPAES creada con éxito');
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
    public function edit(CopaesAccreditation $copaesAccreditation)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar acreditación COPAES',
            'routeName'     => $this->routeName,
            'copaesAccreditation'  => new CopaesAccreditationResource($copaesAccreditation),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCopaesAccreditationRequest $request, CopaesAccreditation $copaesAccreditation)
    {
        $copaesAccreditation->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación COPAES actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CopaesAccreditation $copaesAccreditation)
    {
        $copaesAccreditation->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Acreditación COPAES eliminada con éxito");
    }
}
