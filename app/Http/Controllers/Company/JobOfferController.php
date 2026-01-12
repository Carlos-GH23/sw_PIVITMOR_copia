<?php

namespace App\Http\Controllers\Company;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Company\JobOffer;
use App\Models\AcademicDegree;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;
use App\Http\Requests\Company\StoreJobOfferRequest;
use App\Http\Requests\Company\UpdateJobOfferRequest;
use App\Http\Resources\Company\JobOfferResource;
use App\Models\Catalogs\JobOfferType;
use App\Services\ContactService;
use App\Traits\Filterable;
use App\Traits\HasOrderableRelations;
use App\Traits\SyncsOneToMany;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Exception;

class JobOfferController extends Controller
{
    use Filterable;
    use HasOrderableRelations;
    use SyncsOneToMany;

    private string $routeName;
    private string $source;
    private Model $model;
    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->source = 'Domains/Company/JobOffer/Pages/';
        $this->routeName = 'jobOffers.';
        $this->model = new JobOffer();
        $this->contactService = $contactService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);

        $this->authorizeResource(JobOffer::class, 'jobOffer');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $query = $this->model
            ->where('user_id', Auth::id())
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('position', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('start_date', 'LIKE', "%{$search}%")
                        ->orWhere('end_date', 'LIKE', "%{$search}%")
                        ->orWhereRelation('jobOfferType', 'name', 'LIKE', "%{$search}%")
                        ->orWhereRelation('academicDegree', 'name', 'LIKE', "%{$search}%");
                });
            })
            ->with(['academicDegree', 'offerType', 'oecdSectors', 'economicSectors']);

        $jobOffers = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return inertia(
            $this->source . 'Index',
            [
                'jobOffers' => JobOfferResource::collection($jobOffers),
                'title' => 'Gestión de Ofertas Laborales',
                'routeName' => $this->routeName,
                'filters' => $filters
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $academicDegrees = AcademicDegree::all();
        $jobOfferTypes = JobOfferType::orderBy('name')->get()->toArray();

        $genders = collect(Gender::cases())->map(fn($gender) => [
            'label' => $gender->value,
            'value' => $gender->value
        ]);

        return inertia(
            $this->source . 'Create',
            [
                'title' => 'Crear Oferta Laboral',
                'routeName' => $this->routeName,
                'academicDegrees' => $academicDegrees,
                'jobOfferTypes' => $jobOfferTypes,
                'genders' => $genders,
                'oecdSectors' => OecdSector::getHierarchy(),
                'economicSectors' => EconomicSector::getHierarchy(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreJobOfferRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $jobOffer = $this->model->create($data);

            $this->contactService->upsertContact($jobOffer, $data['contact']);
            $this->syncsOneToMany($jobOffer->phoneNumbers(), $data['phones'], ['number', 'dial_code', 'type']);
            $this->syncsOneToMany($jobOffer->socialLinks(), $data['social_links'], ['url', 'type']);

            if (isset($data['oecd_sectors'])) {
                $jobOffer->oecdSectors()->sync($data['oecd_sectors']);
            }

            if (isset($data['economic_sectors'])) {
                $jobOffer->economicSectors()->sync($data['economic_sectors']);
            }

            return $jobOffer;
        });

        return redirect()
            ->route($this->routeName . 'index')
            ->with('success', 'Oferta laboral creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOffer $jobOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $jobOffer)
    {
        $academicDegrees = AcademicDegree::all();
        $jobOfferTypes = JobOfferType::orderBy('name')->get()->toArray();

        $genders = collect(Gender::cases())->map(fn($gender) => [
            'label' => $gender->value,
            'value' => $gender->value
        ]);

        $jobOffer->load(['academicDegree', 'oecdSectors', 'economicSectors', 'contact', 'phoneNumbers', 'socialLinks']);

        return inertia(
            $this->source . 'Edit',
            [
                'title' => 'Editar Oferta Laboral',
                'routeName' => $this->routeName,
                'jobOffer' => new JobOfferResource($jobOffer),
                'academicDegrees' => $academicDegrees,
                'genders' => $genders,
                'jobOfferTypes' => $jobOfferTypes,
                'oecdSectors' => OecdSector::getHierarchy(),
                'economicSectors' => EconomicSector::getHierarchy()

            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobOfferRequest $request, JobOffer $jobOffer)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $jobOffer) {
            $jobOffer->update($data);

            $this->contactService->upsertContact($jobOffer, $data['contact']);
            $this->syncsOneToMany($jobOffer->phoneNumbers(), $data['phones'], ['number', 'dial_code', 'type']);
            $this->syncsOneToMany($jobOffer->socialLinks(), $data['social_links'], ['url', 'type']);

            if (isset($data['oecd_sectors'])) {
                $jobOffer->oecdSectors()->sync($data['oecd_sectors']);
            }

            if (isset($data['economic_sectors'])) {
                $jobOffer->economicSectors()->sync($data['economic_sectors']);
            }

            return $jobOffer;
        });

        return redirect()
            ->route($this->routeName . 'index')
            ->with('success', 'Oferta laboral actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $jobOffer)
    {
        try {
            $jobOffer->delete();

            return redirect()
                ->route($this->routeName . 'index')
                ->with('success', 'Oferta laboral eliminada correctamente.');
        } catch (Exception $e) {
            return redirect()
                ->route($this->routeName . 'index')
                ->with('error', 'Ocurrió un error al eliminar la oferta: ' . $e->getMessage());
        }
    }

    public function getOrderableRelations(): array
    {
        return [
            'academic_degree_id' => ['academic_degree_id', 'academic_degrees', 'name'],
            'job_offer_type_id' => ['job_offer_type_id', 'job_offer_types', 'name']
        ];
    }

    public function enable(JobOffer $jobOffer)
    {
        $this->authorize('enable', $jobOffer);

        try {
            DB::transaction(function () use ($jobOffer) {
                $jobOffer->is_active = $jobOffer->is_active ? 0 : 1;
                $jobOffer->save();
            });
            return back()->with('success', 'Oferta laboral actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }
}
