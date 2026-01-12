<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\AcademicOfferings\FimpesAccreditation;
use App\Http\Resources\Institution\FimpesAccreditationResource;
use App\Http\Requests\Catalogs\StoreFimpesAccreditationRequest;
use App\Http\Requests\Catalogs\UpdateFimpesAccreditationRequest;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;


class FimpesAccreditationController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/FimpesAccreditation/';
        $this->model = new FimpesAccreditation();
        $this->routeName = 'fimpesAccreditations.';

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

        $fimpesAccreditations = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de acreditaciones FIMPES',
            'fimpesAccreditations'    => FimpesAccreditationResource::collection($fimpesAccreditations),
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
            'title'     => 'Agregar acreditación FIMPES',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFimpesAccreditationRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación FIMPES creada con éxito');
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
    public function edit(FimpesAccreditation $fimpesAccreditation)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar acreditación FIMPES',
            'routeName'     => $this->routeName,
            'fimpesAccreditation'  => new FimpesAccreditationResource($fimpesAccreditation),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFimpesAccreditationRequest $request, FimpesAccreditation $fimpesAccreditation)
    {
        $fimpesAccreditation->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación FIMPES actualizada con éxito');
    }

    /**
     * Remove the specified resource in storage.
     */
    public function destroy(FimpesAccreditation $fimpesAccreditation)
    {
        $fimpesAccreditation->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación FIMPES eliminada con éxito');
    }
}
