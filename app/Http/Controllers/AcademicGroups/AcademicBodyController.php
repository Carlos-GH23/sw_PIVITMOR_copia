<?php

namespace App\Http\Controllers\AcademicGroups;

use App\Models\Academic;
use App\Models\Institution\Department;
use App\Http\Resources\AcademicBodyResource;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\AcademicDiscipline;
use App\Models\AcademicGroups\ConsolidationDegree;
use App\Models\AcademicGroups\ResearchLine;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicGroups\StoreAcademicBodyRequest;
use App\Http\Requests\AcademicGroups\UpdateAcademicBodyRequest;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Services\AcademicBodyService;
use App\Services\CSVImportService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AcademicBodyController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;
    protected CSVImportService $csvImportService;

    public function __construct(private AcademicBodyService $academicBodyService, CSVImportService $csvImportService)
    {
        $this->source    = "Domains/Institution/AcademicBody/Pages/";
        $this->routeName = "academicBodies.";
        $this->model     = new AcademicBody();
        $this->csvImportService = $csvImportService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create', 'uploadCSV']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(AcademicBody::class, 'academicBody');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $academicBodies = $this->academicBodyService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'title' => 'Cuerpos Académicos',
            'academicBodies' => AcademicBodyResource::collection($academicBodies),
            'routeName' => $this->routeName,
            'filters' => $filters,
            'modelClass' => 'AcademicGroups\\AcademicBody',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Cuerpos Académicos',
            'routeName' => $this->routeName,
            'consolidationDegrees' => ConsolidationDegree::orderBy('name')->get(),
            'departments' => Department::where('is_active', true)->institution()->select('id', 'name')->get(),
            'academics' => Academic::where('is_active', true)->institution()->orderBy('first_name')->get(),
            'researchLines' => ResearchLine::where('is_active', true)->institution()->orderBy('name')->get(),
            'economicSectors' => EconomicSector::getHierarchy(),
            'oecdSectors' => OecdSector::getHierarchy(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicBodyRequest $request)
    {
        try {
            $this->academicBodyService->store($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Cuerpo académico creado con éxito');
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
    public function edit(AcademicBody $academicBody): Response
    {
        $academicBody->load('academics', 'researchLines', 'knowledgeLines', 'department', 'consolidationDegree', 'files', 'economicSectors', 'oecdSectors');
        return Inertia::render("{$this->source}Edit", [
            'title' => 'Editar Cuerpo Académico',
            'routeName' => $this->routeName,
            'academicBody' => new AcademicBodyResource($academicBody),
            'consolidationDegrees' => ConsolidationDegree::orderBy('name')->get(),
            'departments' => Department::where('is_active', true)->institution()->select('id', 'name')->get(),
            'academics' => Academic::where('is_active', true)->institution()->orderBy('first_name')->get(),
            'researchLines' => ResearchLine::where('is_active', true)->institution()->orderBy('name')->get(),
            'economicSectors' => EconomicSector::getHierarchy(),
            'oecdSectors' => OecdSector::getHierarchy(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicBodyRequest $request, AcademicBody $academicBody)
    {
        try {
            $this->academicBodyService->update($academicBody, $request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Cuerpo académico actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicBody $academicBody)
    {
        try {
            $this->academicBodyService->destroy($academicBody);
            return redirect()->route("{$this->routeName}index")->with('success', 'Cuerpo académico eliminado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al eliminar el registro');
        }
    }

    public function enable(AcademicBody $academicBody)
    {
        $this->authorize('enable', $academicBody);
        try {
            DB::transaction(function () use ($academicBody) {
                $academicBody->is_active = !$academicBody->is_active;
                $academicBody->save();
            });
            return back()->with('success', 'Estatus del cuerpo académico actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }
}
