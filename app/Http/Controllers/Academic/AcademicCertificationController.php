<?php

namespace App\Http\Controllers\Academic;

use App\Http\Requests\Academic\StoreAcademicCertificationRequest;
use App\Http\Resources\Academic\AcademicCertificationResource;
use App\Services\Academic\AcademicCertificationService;
use App\Models\Academic\AcademicCertification;
use App\Models\Academic\AccreditationEntity;
use App\Models\Academic\CertificationStatus;
use App\Models\Academic\CertificationLevel;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\UpdateAcademicCertificationRequest;
use Illuminate\Http\Request;
use App\Traits\Filterable;
use App\Models\Country;
use Inertia\Response;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AcademicCertificationController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;
    protected AcademicCertificationService $academicCertificationService;

    public function __construct(AcademicCertificationService $academicCertificationService)
    {
        $this->routeName = "academics.certifications.";
        $this->source    = "Domains/Academic/Certification/Pages/";
        $this->academicCertificationService = $academicCertificationService;
        $this->model     = new AcademicCertification();

        $this->middleware("permission:{$this->routeName}index")->only('index', 'show');
        $this->middleware("permission:{$this->routeName}store")->only(['create', 'store']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only('destroy');
        $this->middleware("permission:{$this->routeName}enable")->only('enable');

        $this->authorizeResource(AcademicCertification::class, 'certification');
    }
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = (object) $this->getFiltersBase($request->query());
        $query = $this->academicCertificationService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'title' => 'Certificaciones',
            'routeName' => $this->routeName,
            'filters' => $filters,
            'certifications' => AcademicCertificationResource::collection($query),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'      => 'Agregar certificación',
            'routeName'  => $this->routeName,
            'countries'  => Country::select('id', 'name')->get(),
            'levels'     => CertificationLevel::select('id', 'name')->get(),
            'entities'   => AccreditationEntity::select('id', 'name')->get(),
            'statuses'   => CertificationStatus::select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicCertificationRequest $request)
    {
        try {
            $this->academicCertificationService->store($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Certificación creada con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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
    public function edit(AcademicCertification $certification)
    {
        $certification->load(['files', 'certificationLevel', 'accreditationEntity', 'country', 'status']);
        $certification = new AcademicCertificationResource($certification);


        return Inertia::render("{$this->source}Edit", [
            'title'      => 'Editar certificación',
            'routeName'  => $this->routeName,
            'countries'  => Country::select('id', 'name')->get(),
            'levels'     => CertificationLevel::select('id', 'name')->get(),
            'entities'   => AccreditationEntity::select('id', 'name')->get(),
            'statuses'   => CertificationStatus::select('id', 'name')->get(),
            'certification' => $certification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicCertificationRequest $request, AcademicCertification $certification)
    {
        try {
            $this->academicCertificationService->update($certification, $request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Certificación actualizada con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicCertification $certification)
    {
        try {
            $this->academicCertificationService->destroy($certification);
            return redirect()->route("{$this->routeName}index")->with('success', 'Certificación eliminada con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function enable(AcademicCertification $certification)
    {
        $this->authorize('enable', $certification);
        try {
            DB::transaction(function () use ($certification) {
                $certification->is_active = !$certification->is_active;
                $certification->save();
            });
            return back()->with('success', 'Estatus de la certificación actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }
}
