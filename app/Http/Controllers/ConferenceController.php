<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Services\ConferenceService;
use App\Traits\Filterable;
use App\Http\Requests\StoreConferenceRequest;
use App\Http\Requests\UpdateConferenceRequest;
use App\Http\Resources\ConferenceResource;
use App\Models\Institution\Department;
use App\Models\Academic;
use App\Models\AudienceType;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;


class ConferenceController extends Controller
{
    use Filterable;
    private Conference $model;
    private string $source;
    private string $routeName;
    protected ConferenceService $conferenceService;

    public function __construct(ConferenceService $conferenceService)
    {
        $this->source = 'Domains/Institution/Conferences/Pages/';
        $this->model = new Conference();
        $this->routeName = 'conferences.';
        $this->conferenceService = $conferenceService;
        
        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);
        
        $this->authorizeResource(Conference::class, 'conference');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $conferences = $this->conferenceService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'conferences'  => ConferenceResource::collection($conferences),
            'title'        => 'Gestión de Conferencias',
            'routeName'    => $this->routeName,
            'filters'      => $filters
        ]);
    }

    public function create()
    {
        $modalityEnum = ['Presencial', 'Virtual', 'Híbrido'];

        $modalities = collect($modalityEnum)->map(function($item) {
            return ['value' => $item, 'label' => $item];
        });

        $user = Auth::user();
        $institutionId = $user->institution?->id ?? $user->academic?->department?->institution_id;

        return Inertia::render("{$this->source}Create", [
            'title'            => 'Registrar conferencia',
            'departments'      => Department::where('institution_id', $institutionId)->orderBy('name')->get(),
            'academics'        => Academic::select(['id', 'first_name', 'last_name', 'second_last_name'])
                ->whereHas('department', function ($q) use ($institutionId) {
                    $q->where('institution_id', $institutionId);
                })
                ->orderBy('first_name')->get()->map(function ($academic) {
                    return [
                        'id' => $academic->id,
                        'name' => $academic->full_name
                    ];
                }),
            'oecdSectors'      => OecdSector::getHierarchy(),
            'economicSectors'  => EconomicSector::getHierarchy(),
            'audienceTypes'    => AudienceType::orderBy('type')->get(),
            'modality'         => $modalities,
            'languages'        => Language::orderBy('name')->get(),
            'routeName'        => $this->routeName,
        ]);
    }

    public function store(StoreConferenceRequest $request)
    {
        try {
            $this->conferenceService->store($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Conferencia creada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar crear el registro');
        }
    }

    public function show(Conference $conference)
    {
        $conference->load([
            'keywords',
            'files',
            'oecdSectors',
            'economicSectors',
            'academics',
            'department',
            'audienceTypes',
            'conferenceStatus',
            'language'
        ]);

        return Inertia::render("{$this->source}Show", [
            'title'      => 'Detalle de Conferencia',
            'routeName'  => $this->routeName,
            'conference' => new ConferenceResource($conference)
        ]);
    }

    public function edit(Conference $conference)
    {
        $conference->load(
            'keywords',
            'files',
            'oecdSectors',
            'economicSectors',
            'academics',
            'department',
            'audienceTypes'
        );

        $modalityEnum = ['Presencial', 'Virtual', 'Híbrido'];

        $modalities = collect($modalityEnum)->map(function($item) {
            return ['value' => $item, 'label' => $item];
        });

        $user = Auth::user();
        $institutionId = $user->institution?->id ?? $user->academic?->department?->institution_id;

        return Inertia::render("{$this->source}Edit", [
            'title'            => 'Editar conferencia',
            'routeName'        => $this->routeName,
            'departments'      => Department::where('institution_id', $institutionId)->orderBy('name')->get(),
            'academics'        => Academic::select(['id', 'first_name', 'last_name', 'second_last_name'])
                ->whereHas('department', function ($q) use ($institutionId) {
                    $q->where('institution_id', $institutionId);
                })
                ->orderBy('first_name')->get()->map(function ($academic) {
                    return [
                        'id' => $academic->id,
                        'name' => $academic->full_name
                    ];
                }),
            'oecdSectors'      => OecdSector::getHierarchy(),
            'economicSectors'  => EconomicSector::getHierarchy(),
            'audienceTypes'    => AudienceType::orderBy('type')->get(),
            'modality'         => $modalities,
            'languages'        => Language::orderBy('name')->get(),
            'conference'       => new ConferenceResource($conference)
        ]);
    }

    public function update(UpdateConferenceRequest $request, Conference $conference)
    {
        try {
            $this->conferenceService->update($conference, $request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Conferencia actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    public function destroy(Conference $conference)
    {
        try {
            $this->conferenceService->delete($conference);
            return redirect()->route("{$this->routeName}index")->with('success', 'Conferencia eliminada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar eliminar el registro');
        }
    }

    public function enable(Conference $conference)
    {
        $this->authorize('enable', $conference);
        try {
            $conference->conference_status_id = $conference->conference_status_id == 2 ? 3 : 2;
            $conference->save();
            return redirect()->route("{$this->routeName}index")->with('success', 'Estado de la conferencia actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el estado');
        }
    }
}
