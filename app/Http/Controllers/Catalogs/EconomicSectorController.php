<?php

namespace App\Http\Controllers\Catalogs;

use App\Enums\EconomicSectorLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreEconomicSectorRequest;
use App\Http\Requests\Catalogs\UpdateEconomicSectorRequest;
use App\Models\Catalogs\EconomicSector;
use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Models\EconomicSocialSector;
use App\Traits\Filterable;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class EconomicSectorController extends Controller
{
    use Filterable, HasOrderableRelations;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/EconomicSector/';
        $this->model = new EconomicSector();
        $this->routeName = 'economicSectors.';

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
                    ->orWhereRelation('parent', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('economicSocialSector', 'name', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->level ?? null, function ($query, $level) {
                $query->where('level', $level);
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);

        $economicSectors = $query->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'economic_sectors'  => EconomicSectorResource::collection($economicSectors),
            'title'             => 'Catálogo de sectores económicos',
            'routeName'         => $this->routeName,
            'filters'           => $filters,
            'levelOptions'      => EconomicSectorLevel::toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EconomicSector::with('children.children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name']);
        $economicSocialSectors = EconomicSocialSector::orderBy('name')->get(['id', 'name']);
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar sector económico',
            'routeName' => $this->routeName,
            'categories' => $categories,
            'economicSocialSectors' => $economicSocialSectors,
            'levelOptions' => EconomicSectorLevel::toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEconomicSectorRequest $request)
    {
        $data = $request->validated();

        $validationError = $this->validateHierarchy($data);
        if ($validationError) {
            return $validationError;
        }

        EconomicSector::create($data);
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector económico creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EconomicSector $economicSector)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EconomicSector $economicSector)
    {
        $economicSector->load(['parent', 'children']);

        $excludeIds = $economicSector->allDescendants()->pluck('id')->push($economicSector->id);

        $categories = EconomicSector::with('children.children')
            ->whereNull('parent_id')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('name')
            ->get(['id', 'name']);
        $economicSocialSectors = EconomicSocialSector::orderBy('name')->get(['id', 'name']);

        $sectorData = [
            'id' => $economicSector->id,
            'name' => $economicSector->name,
            'parent_id' => $economicSector->parent_id ? [
                'value' => $economicSector->parent_id,
                'label' => $economicSector->parent->name,
            ] : null,
            'economic_social_sector_id' => $economicSector->economic_social_sector_id,
            'level' => $economicSector->level,
        ];

        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar sector económico',
            'routeName'         => $this->routeName,
            'sector'            => $sectorData,
            'categories'        => $categories,
            'economicSocialSectors' => $economicSocialSectors,
            'levelOptions'      => EconomicSectorLevel::toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEconomicSectorRequest $request, EconomicSector $economicSector)
    {
        $data = $request->validated();

        $validationError = $this->validateHierarchy($data, $economicSector);
        if ($validationError) {
            return $validationError;
        }

        $economicSector->update($data);
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector económico actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EconomicSector $economicSector)
    {
        $economicSector->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector económico eliminado con éxito');
    }

    protected function applyOrdering($query, string $orderField, string $direction = 'asc'): void
    {
        $baseTable = $query->getModel()->getTable();
        if ($orderField === 'parent_id') {
            $query->leftJoin('economic_sectors as parent_economic', 'parent_economic.id', '=', "{$baseTable}.parent_id")
                ->orderBy('parent_economic.name', $direction)
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
            'parent_id' => ['economic_sectors as parent_economic', 'parent_id', 'name'],
            'economic_social_sector_id' => ['economic_social_sectors', 'economic_social_sector_id', 'name'],
        ];
    }

    private function validateHierarchy(array $data, ?EconomicSector $economicSector = null)
    {
        if ($data['level'] === EconomicSectorLevel::SECTION->value && $data['parent_id'] !== null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Las secciones no pueden tener un sector padre.']);
        }
        if ($data['level'] === EconomicSectorLevel::DIVISION->value && $data['parent_id'] === null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Las divisiones deben tener una sección como padre.']);
        }
        if ($data['level'] === EconomicSectorLevel::GROUP->value && $data['parent_id'] === null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['parent_id' => 'Los grupos deben tener una división como padre.']);
        }

        if (isset($data['parent_id']) && $data['parent_id']) {
            if ($economicSector && $data['parent_id'] == $economicSector->id) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'Un sector no puede ser su propio padre.']);
            }

            if ($economicSector) {
                $economicSector->load('children');
                $descendantIds = $economicSector->allDescendants()->pluck('id');
                if ($descendantIds->contains($data['parent_id'])) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['parent_id' => 'No se puede asignar un descendiente como padre.']);
                }
            }

            $parent = EconomicSector::find($data['parent_id']);
            if ($parent && $parent->getLevel() >= 2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'No se puede crear más de 3 niveles de jerarquía.']);
            }
        }
        return null;
    }
}
