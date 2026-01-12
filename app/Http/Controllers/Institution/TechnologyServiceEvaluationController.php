<?php

namespace App\Http\Controllers\Institution;

use App\Models\TechnologyService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnologyServiceEvaluationRequest;
use App\Http\Resources\TechnologyServiceResource;
use App\Services\TechnologyServiceService;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Notifications\EvaluationNotification;

class TechnologyServiceEvaluationController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;

    public function __construct(private TechnologyServiceService $technologyServiceService)
    {
        $this->routeName = "technologyServices.evaluations.";
        $this->source    = "Domains/Institution/Evaluations/TechnologyServices/Pages/";
        $this->model     = new TechnologyService();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->technologyServiceService->buildQuery($filters->search);
        $query->status(2);
        if (!empty($filters->department_id)) {
            $query->where('department_id', $filters->department_id);
        }
        $technologyServices = $this->technologyServiceService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'technologyServices'  => TechnologyServiceResource::collection($technologyServices),
            'title'         => 'Evaluación de servicios tecnológicos',
            'routeName'     => $this->routeName,
            'filters'       => $filters
        ]);
    }

    public function create(TechnologyService $technologyService)
    {
        $this->authorize('create', ['TechnologyServiceEvaluation', $technologyService]);

        $technologyService->load([
            'department',
            'technologyServiceType',
            'technologyServiceCategory',
            'economicSectors',
            'oecdSectors',
            'facilities',
            'equipments',
            'academics',
            'keywords',
            'photos',
            'files',
            'technologyServiceStatus',
            'assessments.user.photo',
        ]);

        return Inertia::render("{$this->source}Create", [
            'title'             => 'Evaluar servicio tecnológico',
            'routeName'         => $this->routeName,
            'technologyService' => new TechnologyServiceResource($technologyService),
        ]);
    }

    public function store(StoreTechnologyServiceEvaluationRequest $request, TechnologyService $technologyService)
    {
        $this->authorize('create', ['TechnologyServiceEvaluation', $technologyService]);

        try {
            $technologyService->assessments()->create($request->validated());
            $technologyService->update(['technology_service_status_id' => $request->input('technology_service_status_id')]);

            $technologyService->user->notify(new EvaluationNotification($technologyService));
            return redirect()->route("{$this->routeName}index")->with('success', 'Evaluación creada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al crear el registro');
        }
    }
}
