<?php

namespace App\Http\Controllers\Institution;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\StoreAcademicRequest;
use App\Http\Requests\Institution\UpdateAcademicRequest;
use App\Http\Resources\Institution\AcademicResource;
use App\Models\Academic;
use App\Models\AcademicDegree;
use App\Models\AcademicPosition;
use App\Models\Institution\Department;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;
use App\Models\Institution\SniLevel;
use App\Models\ResearchArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\AcademicService;
use App\Services\CSVImportService;
use App\Traits\Filterable;
use Exception;

class AcademicController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Academic $model;
    protected CSVImportService $csvImportService;

    public function __construct(private AcademicService $academicService, CSVImportService $csvImportService)
    {
        $this->routeName = "institutions.academics.";
        $this->source = "Domains/Institution/Academic/Pages/";
        $this->model = new Academic();
        $this->csvImportService = $csvImportService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);

        $this->authorizeResource(Academic::class, 'academic');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query   = $this->academicService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'title'         => 'Personal Académico',
            'academics'     => AcademicResource::collection($query),
            'routeName'     => $this->routeName,
            'filters'       => $filters,
            'modelClass'   => 'Academic',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render("{$this->source}Create", [
            'title'             => 'Agregar Personal Académico',
            'routeName'         => $this->routeName,
            'positions'         => AcademicPosition::select('id', 'name')->get(),
            'academicDegrees'   => AcademicDegree::select('id', 'name')->get(),
            'departments'       => Department::where('is_active', true)->institution()->select('id', 'name')->get(),
            'sniiAreas'         => ResearchArea::select('id', 'name')->orderBy('order')->get(),
            'sniiLevels'        => SniLevel::select('id', 'name')->get(),
            'oecdSectors'       => OecdSector::getHierarchy(),
            'economicSectors'   => EconomicSector::getHierarchy(),
            'genders'           => Gender::toSelectArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicRequest $request)
    {
        try {
            $this->academicService->store($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Personal académico creado correctamente.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al crear el registro');
        }
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
    public function edit(Academic $academic): Response
    {
        $academic->load([
            'photo',
            'academicPosition',
            'academicDegree',
            'department',
            'contact',
            'knowledgeLines',
            'sniMembership',
            'desirableProfile',
            'economicSectors',
            'oecdSectors',
        ]);
        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar Personal Académico',
            'routeName'         => $this->routeName,
            'academic'          => new AcademicResource($academic),
            'positions'         => AcademicPosition::select('id', 'name')->get(),
            'academicDegrees'   => AcademicDegree::select('id', 'name')->get(),
            'departments'       => Department::where('is_active', true)->institution()->select('id', 'name')->get(),
            'sniiAreas'         => ResearchArea::select('id', 'name')->orderBy('order')->get(),
            'sniiLevels'        => SniLevel::select('id', 'name')->get(),
            'oecdSectors'       => OecdSector::getHierarchy(),
            'economicSectors'   => EconomicSector::getHierarchy(),
            'genders'           => Gender::toSelectArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicRequest $request, Academic $academic)
    {
        try {
            $this->academicService->update($academic, $request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Personal académico modificado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Academic $academic)
    {
        try {
            $this->academicService->destroy($academic);
            return redirect()->route("{$this->routeName}index")->with('success', 'Personal académico eliminado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al eliminar el registro');
        }
    }

    public function enable(Academic $academic)
    {
        $this->authorize('enable', $academic);
        try {
            $this->academicService->enable($academic);
            return back()->with('success', 'Estatus del académico actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }
}
