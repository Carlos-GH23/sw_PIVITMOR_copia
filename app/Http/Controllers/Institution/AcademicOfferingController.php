<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\StoreAcademicOfferingRequest;
use App\Http\Requests\Institution\UpdateAcademicOfferingRequest;
use App\Http\Resources\Institution\AcademicOfferingResource;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\AcademicOfferings\EducationalLevel;
use App\Models\AcademicOfferings\FimpesAccreditation;
use App\Models\AcademicOfferings\CieesAccreditation;
use App\Models\AcademicOfferings\CopaesAccreditation;
use App\Models\AcademicOfferings\StudyMode;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Services\AcademicOfferingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Institution\Department;
use App\Traits\Filterable;

class AcademicOfferingController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected AcademicOffering $model;
    protected AcademicOfferingService $academicOfferingService;

    public function __construct(AcademicOfferingService $academicOfferingService)
    {
        $this->routeName  = 'academicOfferings.';
        $this->source = 'Domains/Institution/AcademicOfferings/Pages/';
        $this->model = new AcademicOffering();
        $this->academicOfferingService = $academicOfferingService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update', 'enable']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);

        $this->authorizeResource(AcademicOffering::class, 'academicOffering');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->academicOfferingService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'title' => 'Oferta Educativa',
            'offerings' => AcademicOfferingResource::collection($query),
            'routeName' => $this->routeName,
            'filters' => $filters
        ]);
    }

    public function create(): Response
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar Oferta Educativa',
            'routeName' => $this->routeName,
            'educationalLevels' => EducationalLevel::all(['id', 'name']),
            'studyModes' => StudyMode::all(['id', 'name']),
            'departments' => Department::query()->institution()->get(['id', 'name']),
            'copaesAccreditations' => CopaesAccreditation::all(['id', 'name']),
            'cieesAccreditations' => CieesAccreditation::all(['id', 'name']),
            'fimpesAccreditations' => FimpesAccreditation::all(['id', 'name']),
            'oecdSectors' => OecdSector::getHierarchy(),
            'economicSectors' => EconomicSector::getHierarchy(),
        ]);
    }

    public function store(StoreAcademicOfferingRequest $request)
    {
        try {
            $this->academicOfferingService->createAcademicOffering($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Oferta educativa creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error creating academic offering: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al guardar los datos.');
        }
    }

    public function edit(AcademicOffering $academicOffering)
    {
        $academicOffering->load([
            'files',
            'oecdSectors',
            'economicSectors',
            'keywords',
            'department',
            'educationalLevel',
            'studyMode',
            'copaesAccreditationProgram.copaesAccreditation',
            'cieesAccreditationProgram.cieesAccreditation',
            'fimpesAccreditation',
            'postgraduateDetail',
        ]);

        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar Oferta Educativa',
            'routeName'         => $this->routeName,
            'academicOffering'  => new AcademicOfferingResource($academicOffering),
            'educationalLevels' => EducationalLevel::select('id', 'name')->get(),
            'studyModes'        => StudyMode::select('id', 'name')->get(),
            'departments'       => Department::query()->institution()->get(['id', 'name']),
            'copaesAccreditations'  => CopaesAccreditation::all(['id', 'name']),
            'cieesAccreditations'   => CieesAccreditation::all(['id', 'name']),
            'fimpesAccreditations'  => FimpesAccreditation::all(['id', 'name']),
            'oecdSectors' => OecdSector::getHierarchy(),
            'economicSectors' => EconomicSector::getHierarchy(),
        ]);
    }

    public function update(UpdateAcademicOfferingRequest $request, AcademicOffering $academicOffering)
    {
        try {
            $this->academicOfferingService->updateAcademicOffering($academicOffering, $request->validated());
            return redirect()->route("academicOfferings.index")->with('success', 'Oferta educativa actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error updating academic offering: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al actualizar los datos.');
        }
    }
    public function destroy(AcademicOffering $academicOffering)
    {
        try {
            $this->academicOfferingService->destroy($academicOffering);
            return redirect()->route("{$this->routeName}index")->with('success', 'Oferta educativa eliminada correctamente.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar eliminar la oferta educativa.');
        }
    }

    public function enable(AcademicOffering $academicOffering)
    {
        try {
            $academicOffering->is_active = $academicOffering->is_active ? 0 : 1;
            $academicOffering->save();

            return redirect()->route("{$this->routeName}index")->with('success', 'Estatus de la oferta educativa actualizado correctamente.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar habilitar la oferta educativa.');
        }
    }
}
