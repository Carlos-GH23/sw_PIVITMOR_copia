<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\AcademicOfferings\StudyMode;
use App\Http\Resources\Institution\StudyModeResource;
use App\Http\Requests\Catalogs\StoreEducationalModalityRequest;
use App\Http\Requests\Catalogs\UpdateEducationalModalityRequest;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationalModalityController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/EducationalModality/';
        $this->model = new StudyMode();
        $this->routeName = 'educationalModalities.';

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

        $educationalModalities = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de modalidades educativas',
            'educationalModalities'    => StudyModeResource::collection($educationalModalities),
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
            'title'     => 'Agregar modalidad educativa',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationalModalityRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Modalidad educativa creada con éxito');
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
    public function edit(StudyMode $educationalModality)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar modalidad educativa',
            'routeName'     => $this->routeName,
            'educationalModality'  => new StudyModeResource($educationalModality),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationalModalityRequest $request, StudyMode $educationalModality)
    {
        $educationalModality->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Modalidad educativa actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyMode $educationalModality)
    {
        $educationalModality->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Modalidad educativa eliminada con éxito');
    }
}
