<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Institution\CieesAccreditationResource;
use App\Models\AcademicOfferings\CieesAccreditation;
use App\Http\Requests\Catalogs\StoreCieesAccreditationRequest;
use App\Http\Requests\Catalogs\UpdateCieesAccreditationRequest;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CieesAccreditationController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/CieesAccreditation/';
        $this->model = new CieesAccreditation();
        $this->routeName = 'cieesAccreditations.';

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

        $cieesAccreditations = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de acreditaciones CIEES',
            'cieesAccreditations'    => CieesAccreditationResource::collection($cieesAccreditations),
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
            'title'     => 'Agregar acreditación CIEES',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCieesAccreditationRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación CIEES creada con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CieesAccreditation $cieesAccreditation)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar acreditación CIEES',
            'routeName'     => $this->routeName,
            'cieesAccreditation'  => new CieesAccreditationResource($cieesAccreditation),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCieesAccreditationRequest $request, CieesAccreditation $cieesAccreditation)
    {
        $cieesAccreditation->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Acreditación CIEES actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CieesAccreditation $cieesAccreditation)
    {
        $cieesAccreditation->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Acreditación CIEES eliminada con éxito");
    }
}
