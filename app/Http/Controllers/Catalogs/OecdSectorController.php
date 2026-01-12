<?php

namespace App\Http\Controllers\Catalogs;

use App\Enums\OecdLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreOecdSectorRequest;
use App\Http\Requests\Catalogs\UpdateOecdSectorRequest;
use App\Models\Catalogs\OecdSector;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Models\EconomicSocialSector;
use App\Traits\Filterable;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OecdSectorController extends Controller
{
    use Filterable, HasOrderableRelations;

    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/OECD/';
        $this->model = new OecdSector();
        $this->routeName = 'oecdSector.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $filters->level = $request->query('level', null);

        $query = $this->model
            ->with(['parent', 'economicSocialSector'])
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('level', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('parent', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('economicSocialSector', 'name', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->level, function ($query, $level) {
                $query->where('level', $level);
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);

        $oecdSectors = $query->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'         => 'Catálogo OCDE',
            'oecdData'      => OecdSectorResource::collection($oecdSectors),
            'routeName'     => $this->routeName,
            'filters'       => $filters,
            'levelOptions'  => OecdLevel::toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = OecdSector::with('children.children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name']);

        $economicSocialSectors = EconomicSocialSector::orderBy('name')->get(['id', 'name']);

        return Inertia::render("{$this->source}Create", [
            'title'         => 'Agregar OCDE',
            'routeName'     => $this->routeName,
            'categories'    => $categories,
            'economicSocialSectors' => $economicSocialSectors,
            'levelOptions'  => OecdLevel::toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOecdSectorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $validationError = $this->validateHierarchy($data);
        if ($validationError) {
            return $validationError;
        }

        OecdSector::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'economic_social_sector_id' => $data['economic_social_sector_id'] ?? null,
            'level' => $data['level'],
        ]);

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Disciplina creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OecdSector $oecdSector): Response
    {
        $oecdSector->load(['parent', 'children']);

        return Inertia::render("{$this->source}Show", [
            'title'         => 'Detalle de disciplina cientifica y tecnológica',
            'routeName'     => $this->routeName,
            'oecdSector'    => new OecdSectorResource($oecdSector)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OecdSector $oecdSector): Response
    {
        $oecdSector->load(['parent', 'children']);

        $excludeIds = $oecdSector->allDescendants()->pluck('id')->push($oecdSector->id);

        $categories = OecdSector::with('children.children')
            ->whereNull('parent_id')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        $economicSocialSectors = EconomicSocialSector::orderBy('name')->get(['id', 'name']);

        $sectorData = [
            'id' => $oecdSector->id,
            'name' => $oecdSector->name,
            'parent_id' => $oecdSector->parent_id ? [
                'value' => $oecdSector->parent_id,
                'label' => $oecdSector->parent->name,
            ] : null,
            'economic_social_sector_id' => $oecdSector->economic_social_sector_id,
            'level' => $oecdSector->level,
        ];

        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar OCDE',
            'routeName'     => $this->routeName,
            'oecdSector'    => $sectorData,
            'categories'    => $categories,
            'economicSocialSectors' => $economicSocialSectors,
            'levelOptions'  => OecdLevel::toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOecdSectorRequest $request, OecdSector $oecdSector): RedirectResponse
    {
        $data = $request->validated();

        $validationError = $this->validateHierarchy($data, $oecdSector);
        if ($validationError) {
            return $validationError;
        }

        $oecdSector->update($data);

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Disciplina actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OecdSector $oecdSector): RedirectResponse
    {
        $hasChildren = OecdSector::where('parent_id', $oecdSector->id)->exists();

        if ($hasChildren) {
            return redirect()
                ->route("{$this->routeName}index")
                ->with('error', 'No se puede eliminar esta disciplina porque tiene subcategorías asociadas.');
        }

        $oecdSector->delete();

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Disciplina eliminada correctamente.');
    }

    protected function applyOrdering($query, string $orderField, string $direction = 'asc'): void
    {
        $baseTable = $query->getModel()->getTable();
        if ($orderField === 'parent_id') {
            $query->leftJoin('oecd_sectors as parent_oecd', 'parent_oecd.id', '=', "{$baseTable}.parent_id")
                ->orderBy('parent_oecd.name', $direction)
                ->select("{$baseTable}.*");
        } else {
            $relations = $this->getOrderableRelations();

            if (isset($relations[$orderField])) {
                [$table, $foreignKey, $orderColumn] = $relations[$orderField];
                $query->leftJoin($table, "{$table}.id", '=', "{$baseTable}.{$foreignKey}")
                    ->orderBy("{$table}.{$orderColumn}", $direction)
                    ->select("{$baseTable}.*");
            } else {
                $query->orderBy($orderField, $direction);
            }
        }
    }

    protected function getOrderableRelations(): array
    {
        return [
            'parent_id' => ['oecd_sectors as parent_oecd', 'parent_id', 'name'],
            'economic_social_sector_id' => ['economic_social_sectors', 'economic_social_sector_id', 'name'],
        ];
    }

    private function validateHierarchy(array $data, ?OecdSector $oecdSector = null)
    {
        if ($data['level'] === OecdLevel::MAIN_AREA->value && ($data['parent_id'] ?? null) !== null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Las áreas principales no pueden tener un sector padre.']);
        }
        if ($data['level'] === OecdLevel::SUBAREA->value && ($data['parent_id'] ?? null) === null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Las subáreas deben tener un área principal como padre.']);
        }
        if ($data['level'] === OecdLevel::DISCIPLINE->value && ($data['parent_id'] ?? null) === null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Las disciplinas deben tener una subárea como padre.']);
        }

        if (isset($data['parent_id']) && $data['parent_id']) {
            if ($oecdSector && $data['parent_id'] == $oecdSector->id) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'Un sector no puede ser su propio padre.']);
            }

            if ($oecdSector) {
                $oecdSector->load('children');
                $descendantIds = $oecdSector->allDescendants()->pluck('id');
                if ($descendantIds->contains($data['parent_id'])) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['parent_id' => 'No se puede asignar un descendiente como padre']);
                }
            }

            $parent = OecdSector::find($data['parent_id']);
            if ($parent && $parent->getLevel() >= 2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'No se puede crear más de 3 niveles de jerarquía']);
            }
        }
        return null;
    }
}
