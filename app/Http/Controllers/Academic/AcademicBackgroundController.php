<?php

namespace App\Http\Controllers\Academic;

use App\Models\Academic\AcademicBackground;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Academic\StoreAcademicBackgroundRequest;
use App\Http\Requests\Academic\UpdateAcademicBackgroundRequest;
use App\Models\Catalogs\KnowledgeArea;
use App\Models\AcademicDegree;
use App\Models\Country;
use App\Services\FileService;
use App\DTOs\FileStorageConfig;
use App\Http\Controllers\Controller;
use App\Traits\Filterable;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\Academic\AcademicBackgroundResource;
use App\Traits\HasOrderableRelations;

class AcademicBackgroundController extends Controller
{
    use Filterable;
    use HasOrderableRelations;
    private AcademicBackground $model;
    private string $source;
    private string $routeName;
    protected FileService $fileService;
    protected FileStorageConfig $config;


    public function __construct()
    {
        $this->model = new AcademicBackground();
        $this->source = 'Domains/Academic/AcademicBackground/Pages/';
        $this->routeName = 'academics.academicBackgrounds.';
        $this->fileService = new FileService();
        $this->config = new FileStorageConfig('private', 'academic/academic_backgrounds', 'files');

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);

        $this->authorizeResource(AcademicBackground::class, 'academicBackground');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $query = $this->model
            ->where('academic_id', Auth::user()->academic?->id ?? null)
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('academic_title', 'LIKE', '%' . $search . '%')
                        ->orWhere('certificate_number', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('academicDegree', 'name', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('knowledgeArea', 'name', 'LIKE', '%' . $search . '%')
                        ->orWhere('degree_obtained_at', 'LIKE', '%' . $search . '%');
                });
            })
            ->with(['academicDegree', 'knowledgeArea', 'country', 'files']);

        $this->applyOrdering($query, $filters->order, $filters->direction);
        $academicBackgrounds = $query->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'academicBackgrounds' => AcademicBackgroundResource::collection($academicBackgrounds),
            'title' => 'Gestión de Formación Académica',
            'routeName' => $this->routeName,
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $academicDegrees = AcademicDegree::select('id', 'name')->orderBy('name')->get();
        $knowledgeAreas  = KnowledgeArea::whereNull('parent_id')->select('id', 'name')->orderBy('name')->get();
        $countries       = Country::select('id', 'name')->orderBy('name')->get();

        return Inertia::render("{$this->source}Create", [
            'title'           => 'Crear Formación Académica',
            'routeName'       => $this->routeName,
            'academicDegrees' => $academicDegrees,
            'knowledgeAreas'  => $knowledgeAreas,
            'countries'       => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicBackgroundRequest $request)
    {
        DB::transaction(function () use ($request) {
            $fields = $request->validated();
            $academicBackground = $this->model->create($fields);

            if (!empty($fields['files'])) {
                $this->fileService->storeFiles($academicBackground, $fields['files'], $this->config);
            }
        });

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Formación académica creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicBackground $academicBackground)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicBackground $academicBackground): Response
    {
        $academicBackground->load(['files', 'academicDegree', 'knowledgeArea', 'country']);
        $academicBackground = new AcademicBackgroundResource($academicBackground);

        return Inertia::render("{$this->source}Edit", [
            'title'            => 'Editar formación académica',
            'routeName'        => $this->routeName,
            'academicBackground' => $academicBackground,
            'academicDegrees'  => AcademicDegree::select('id', 'name')->orderBy('name')->get(),
            'knowledgeAreas'   => KnowledgeArea::whereNull('parent_id')->select('id', 'name')->orderBy('name')->get(),
            'countries'        => Country::select('id', 'name')->orderBy('name')->get(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicBackgroundRequest $request, AcademicBackground $academicBackground)
    {
        DB::transaction(function () use ($request, $academicBackground) {
            $fields = $request->validated();
            $academicBackground->update($fields);

            $this->fileService->syncFiles($academicBackground, $fields['files'] ?? [], $this->config);
        });

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Formación académica actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicBackground $academicBackground)
    {
        DB::transaction(function () use ($academicBackground) {
            $this->fileService->deleteFiles($academicBackground->files, $this->config->disk, true);
            $academicBackground->delete();
        });

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Formación académica eliminada correctamente.');
    }

    public function getOrderableRelations(): array
    {
        return [
            'academic_degree' => ['academic_degrees', 'academic_degree_id', 'name'],
            'knowledge_area' => ['knowledge_areas', 'knowledge_area_id', 'name'],
            'country' => ['countries', 'country_id', 'name'],
        ];
    }
}
