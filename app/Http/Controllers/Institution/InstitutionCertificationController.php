<?php

namespace App\Http\Controllers\Institution;

use App\DTOs\FileStorageConfig;
use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\StoreCertificationRequest;
use App\Http\Requests\Institution\UpdateCertificationRequest;
use App\Http\Resources\Institution\CertificationResource;
use App\Models\Institution\InstitutionCertification;
use App\Traits\Filterable;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogs\CertificationType;
use App\Models\Institution\Department;
use App\Models\Catalogs\ResourceType;
use App\Services\CSVImportService;
use App\Traits\HasOrderableRelations;
use App\Models\Academic;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InstitutionCertificationController extends Controller
{
    use Filterable;
    use HasOrderableRelations;

    private const FACILITY = 1;
    private const FACILITY_EQUIPMENT = 2;
    private const ACADEMIC = 3;

    protected string $routeName;
    protected string $source;
    protected Model $model;
    protected FileService $fileService;
    protected FileStorageConfig $config;
    protected CSVImportService $csvImportService;

    public function __construct(FileService $fileService, CSVImportService $csvImportService)
    {
        $this->routeName = 'institutions.certifications.';
        $this->source    = 'Domains/Institution/Certification/Pages/';
        $this->model     = new InstitutionCertification();
        $this->fileService = $fileService;
        $this->csvImportService = $csvImportService;
        $this->config = new FileStorageConfig('private', 'institution/certifications', 'files');

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create', 'uploadCsv']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(InstitutionCertification::class, 'certification');
    }


    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = InstitutionCertification::query()
            ->with(['files', 'certificationType', 'department', 'resourceType'])
            ->when($filters->search, function ($query, $search) {
                $query->where('institution_certifications.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('institution_certifications.description', 'LIKE', '%' . $search . '%')
                    ->orWhere('institution_certifications.certifying_entity', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('department', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('certificationType', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('resourceType', 'name', 'LIKE', '%' . $search . '%');

                if (strtolower($search) === 'activo') {
                    $query->orWhere('is_active', true);
                } elseif (strtolower($search) === 'inactivo') {
                    $query->orWhere('is_active', false);
                }
            })->institution();

        $this->applyOrdering($query, $filters->order, $filters->direction);
        $certifications = $query->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'certificationData'  => CertificationResource::collection($certifications),
            'title'           => 'Gestión de Certificaciones',
            'routeName'       => $this->routeName,
            'filters'         => $filters,
            'model_class'     => 'institution\\institutionCertification',
        ]);
    }

    public function create(): Response
    {
        $certificationTypes = CertificationType::select('id', 'name')->orderBy('name')->get();
        $departments        = Department::select('id', 'name')->where('is_active', true)->institution()->orderBy('name')->get();
        $resourceTypes      = ResourceType::select('id', 'name')->orderBy('name')->get();

        return Inertia::render("{$this->source}Create", [
            'title'               => 'Crear Certificación',
            'routeName'           => $this->routeName,
            'certificationTypes'  => $certificationTypes,
            'departments'         => $departments,
            'resourceTypes'       => $resourceTypes,
        ]);
    }

    public function store(StoreCertificationRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fields = $request->validated();
            $fields['certified_resource_type'] = $this->getResourceClass($fields['resource_type_id']);
            $certification = $this->model->create($fields);

            if (!empty($fields['files'])) {
                $this->fileService->storeFiles($certification, $fields['files'], $this->config);
            }
        });

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Certificación creada correctamente.');
    }


    public function edit(InstitutionCertification $certification): Response
    {
        $certification->load(['files', 'certificationType', 'department', 'resourceType']);
        $certification = new CertificationResource($certification);

        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar Certificación',
            'routeName'         => $this->routeName,
            'certification'     => $certification,
            'certificationTypes' => CertificationType::query()->get(['id', 'name']),
            'departments'       => Department::query()->where('is_active', true)->institution()->get(['id', 'name']),
            'resourceTypes'     => ResourceType::query()->get(['id', 'name']),
        ]);
    }


    public function update(UpdateCertificationRequest $request, InstitutionCertification $certification): RedirectResponse
    {
        DB::transaction(function () use ($request, $certification) {
            $fields = $request->validated();
            $fields['certified_resource_type'] = $this->getResourceClass($fields['resource_type_id']);
            $certification->update($fields);

            $this->fileService->syncFiles($certification, $fields['files'] ?? [], $this->config);
        });

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Certificación actualizada correctamente.');
    }


    public function destroy(InstitutionCertification $certification): RedirectResponse
    {
        DB::transaction(function () use ($certification) {
            $this->fileService->deleteFiles($certification->files, $this->config->disk, true);
            $certification->delete();
        });

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Certificación eliminada correctamente.');
    }

    public function enable(InstitutionCertification $institutionCertification)
    {
        $this->authorize('enable', $institutionCertification);

        try {
            DB::transaction(function () use ($institutionCertification) {
                $institutionCertification->is_active = $institutionCertification->is_active ? 0 : 1;
                $institutionCertification->save();
            });
            return back()->with('success', 'Estatus de la certificación actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }


    protected function getOrderableRelations(): array
    {
        return [
            'certification_type' => ['certification_types', 'certification_type_id', 'name'],
            'department' => ['departments', 'department_id', 'name'],
        ];
    }

    public function getResources(Request $request): JsonResponse
    {
        $departmentId = $request->query('department_id');
        $resourceTypeId = $request->query('resource_type_id');

        if (!$departmentId || !$resourceTypeId) {
            return response()->json([]);
        }

        $items = [];

        switch ((int)$resourceTypeId) {
            case self::ACADEMIC:
                $query = Academic::where('department_id', $departmentId);
                $items = $query->get()->map(function ($item) {
                    return ['id' => $item->id, 'name' => $item->full_name];
                });
                break;
            case self::FACILITY:
                $query = Facility::where('department_id', $departmentId)->where('is_active', true);
                $items = $query->select('id', 'name')->get();
                break;
            case self::FACILITY_EQUIPMENT:
                $query = FacilityEquipment::whereHas('facility', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                });
                $items = $query->select('id', 'name')->get();
                break;
        }

        return response()->json($items);
    }

    private function getResourceClass($resourceTypeId): ?string
    {
        return match ((int)$resourceTypeId) {
            self::ACADEMIC => Academic::class,
            self::FACILITY => Facility::class,
            self::FACILITY_EQUIPMENT => FacilityEquipment::class,
            default => null,
        };
    }
}
