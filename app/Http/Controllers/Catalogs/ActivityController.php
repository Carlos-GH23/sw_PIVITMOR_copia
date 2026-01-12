<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\Activity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Catalogs\ActivityResource;
use App\Http\Requests\Catalogs\StoreActivityRequest;
use App\Http\Requests\Catalogs\UpdateActivityRequest;
use Illuminate\Contracts\Cache\Store;

class ActivityController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "activities.";
        $this->source    = "Core/Catalogs/Activity/";
        $this->model     = new Activity();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->model->query()->when($filters->search, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        });

        $activities = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'activities' => ActivityResource::collection($activities),
            'title'           => 'Catálogo de actividades CT',
            'routeName'       => $this->routeName,
            'filters'         => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'       => 'Agregar actividad',
            'routeName'   => $this->routeName,
            'activities'    => Activity::query()->whereNull('parent_id')->whereDoesntHave('children')->get(),
            'activity_children' => [],
        ]);
    }

    public function store(StoreActivityRequest $request)
    {
        $activity = $this->model->create($request->validated());
        // Asociar hijos seleccionados
        if ($request->has('child_ids') && is_array($request->child_ids)) {
            foreach ($request->child_ids as $childId) {
                $child = Activity::find($childId);
                if ($child) {
                    $child->parent_id = $activity->id;
                    $child->save();
                }
            }
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Actividad agregada correctamente.');
    }

    public function edit(Activity $activity)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'       => 'Editar actividad',
            'routeName'   => $this->routeName,
            'activity'    => $activity,
            'activities'    => Activity::query()->whereNull('parent_id')->whereDoesntHave('children')->where('id', '!=', $activity->id)->get(),
            'activity_children' => Activity::query()->where('parent_id', $activity->id)->get(),
        ]);
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());
        // Asociar actividades seleccionadas
        if ($request->has('child_ids') && is_array($request->child_ids)) {
            foreach ($request->child_ids as $childId) {
                $child = Activity::find($childId);
                if ($child) {
                    $child->parent_id = $activity->id;
                    $child->save();
                }
            }
        }

        // Desasociar actividades removidas
        if ($request->has('removed_children_ids') && is_array($request->removed_children_ids)) {
            foreach ($request->removed_children_ids as $childId) {
                $child = Activity::find($childId);
                if ($child && $child->parent_id === $activity->id) {
                    $child->parent_id = null;
                    $child->save();
                }
            }
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route("{$this->routeName}index")->with('success', 'Actividad eliminada correctamente.');
    }
}
