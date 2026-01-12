<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\StoreDepartmentRequest;
use App\Http\Requests\Institution\UpdateDepartmentRequest;
use App\Models\Institution\Department;
use App\Http\Resources\Institution\DepartmentResource;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends \App\Http\Controllers\Controller
{
    use Filterable;

    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Domains/Institution/Department/Pages/';
        $this->model     = new Department();
        $this->routeName = 'institutions.departments.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(Department::class, 'department');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $query = $this->model->when($filters->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                if (strtolower($search) === 'activo') {
                    $q->orWhere('is_active', true);
                } elseif (strtolower($search) === 'inactivo') {
                    $q->orWhere('is_active', false);
                }
            });
        })
        ->where('institution_id', Auth::user()->getInstitutionId())
        ->when($filters->withTrashed, fn($q) => $q->withTrashed());

        $departments = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Estructura Organizacional',
            'departmentData'  => DepartmentResource::collection($departments),
            'routeName' => $this->routeName,
            'filters'   => $filters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Crear Estructura Organizacional',
            'routeName' => $this->routeName,
        ]);
    }

    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        Department::create($request->validated() + [
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Departamento creado correctamente.');
    }

    public function edit(Department $department): Response
    {
        return Inertia::render("{$this->source}Edit", [
            'title'      => 'Editar Estructura Organizacional',
            'routeName'  => $this->routeName,
            'department' => $department,
        ]);
    }

    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());

        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Departamento actualizado correctamente.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();
        return redirect()
            ->route("{$this->routeName}index")
            ->with('success', 'Departamento eliminado correctamente.');
    }

    public function enable(Department $department)
    {
        $this->authorize('enable', $department);

        try {
            DB::transaction(function () use ($department) {
                $department->is_active = $department->is_active ? 0 : 1;
                $department->save();
            });
            return back()->with('success', 'Departamento actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }
}
