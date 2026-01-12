<?php

namespace App\Http\Controllers\Catalogs;


use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreJobOfferTypeRequest;
use App\Http\Requests\Catalogs\UpdateJobOfferTypeRequest;
use App\Http\Resources\Catalogs\JobOfferTypeResource;
use App\Models\Catalogs\JobOfferType;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;


class JobOfferTypeController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/JobOfferType/';
        $this->model = new JobOfferType();
        $this->routeName = 'jobOfferTypes.';

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

        $jobOfferTypes = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'         => 'Catálogo de tipos de oferta laboral',
            'jobOfferTypes' => JobOfferTypeResource::collection($jobOfferTypes),
            'filters'       => $filters,
            'routeName'     => $this->routeName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar tipo de oferta laboral',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobOfferTypeRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de oferta laboral creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOfferType $jobOfferType)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'        => 'Editar tipo de oferta laboral',
            'routeName'    => $this->routeName,
            'jobOfferType' => new JobOfferTypeResource($jobOfferType),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobOfferTypeRequest $request, JobOfferType $jobOfferType)
    {
        $jobOfferType->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Tipo de oferta laboral actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOfferType $jobOfferType)
    {
        $jobOfferType->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Tipo de oferta laboral eliminado con éxito");
    }
}
