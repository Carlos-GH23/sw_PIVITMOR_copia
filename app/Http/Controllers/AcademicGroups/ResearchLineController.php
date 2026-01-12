<?php

namespace App\Http\Controllers\AcademicGroups;

use App\Models\Academic;
use App\Models\Institution\Department;
use App\Http\Resources\ResearchLineResource;
use App\Models\Catalogs\OecdSector;
use App\Models\AcademicGroups\ResearchLine;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicGroups\StoreResearchLineRequest;
use App\Http\Requests\AcademicGroups\UpdateResearchLineRequest;
use App\Models\Catalogs\EconomicSector;
use App\Services\CSVImportService;
use App\Services\ResearchLineService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ResearchLineController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;
    protected CSVImportService $csvImportService;

    public function __construct(private ResearchLineService $researchLineService, CSVImportService $csvImportService)
    {
        $this->source    = "Domains/Institution/ResearchLine/Pages/";
        $this->routeName = "researchLines.";
        $this->model     = new ResearchLine();
        $this->csvImportService = $csvImportService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create', 'uploadCSV']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(ResearchLine::class, 'researchLine');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $researchLines = $this->researchLineService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'title' => 'Líneas de Investigación',
            'routeName' => $this->routeName,
            'researchLines' => ResearchLineResource::collection($researchLines),
            'filters' => $filters,
            'modelClass' => 'AcademicGroups\\ResearchLine',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Líneas de Investigación',
            'routeName' => $this->routeName,
            'economicSectors' => EconomicSector::getHierarchy(),
            'oecdSectors' => OecdSector::getHierarchy(),
            'departments' => Department::where('is_active', true)->institution()->select('id', 'name')->get(),
            'academics' => Academic::where('is_active', true)->institution()->orderBy('first_name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResearchLineRequest $request)
    {
        try {
            $this->researchLineService->store($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Línea de investigación creada con éxito');
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
    public function edit(ResearchLine $researchLine): Response
    {
        $researchLine->load('logo', 'department', 'economicSectors', 'oecdSectors', 'academics', 'keywords',  'files');
        return Inertia::render("{$this->source}Edit", [
            'title' => 'Editar Línea de Investigación',
            'routeName' => $this->routeName,
            'researchLine' => new ResearchLineResource($researchLine),
            'economicSectors' => EconomicSector::getHierarchy(),
            'oecdSectors' => OecdSector::getHierarchy(),
            'departments' => Department::where('is_active', true)->institution()->select('id', 'name')->get(),
            'academics' => Academic::where('is_active', true)->institution()->orderBy('first_name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResearchLineRequest $request, ResearchLine $researchLine)
    {
        try {
            $this->researchLineService->update($researchLine, $request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Línea de investigación actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResearchLine $researchLine)
    {
        try {
            $this->researchLineService->destroy($researchLine);
            return redirect()->route("{$this->routeName}index")->with('success', 'Línea de investigación creada eliminada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al eliminar el registro');
        }
    }

    public function enable(ResearchLine $researchLine)
    {
        $this->authorize('enable', $researchLine);
        try {
            DB::transaction(function () use ($researchLine) {
                $researchLine->is_active = !$researchLine->is_active;
                $researchLine->save();
            });
            return back()->with('success', 'Estatus de la línea de investigación actualizada con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }
}
