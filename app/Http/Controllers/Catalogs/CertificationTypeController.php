<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\CertificationType;
use App\Http\Resources\Catalogs\CertificationTypeResource;
use App\Http\Requests\Catalogs\UpdateCertificationTypeRequest;
use App\Http\Requests\Catalogs\StoreCertificationTypeRequest;
use Inertia\Inertia;

class CertificationTypeController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->routeName = "certificationTypes.";
        $this->source    = "Core/Catalogs/CertificationType/";
        $this->model     = new CertificationType();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->model
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $certificationTypes = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'              => 'Catálogo de tipos de certificación',
            'certificationTypes' => CertificationTypeResource::collection($certificationTypes),
            'routeName'          => $this->routeName,
            'filters'            => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Crear tipo de certificación',
            'routeName' => $this->routeName,
        ]);
    }

    public function store(StoreCertificationTypeRequest $request)
    {

        $this->model->create($request->validated());

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de certificación creado exitosamente.');
    }

    public function edit(CertificationType $certificationType)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'              => 'Editar tipo de certificación',
            'routeName'          => $this->routeName,
            'certificationType'  => $certificationType
        ]);
    }

    public function update(UpdateCertificationTypeRequest $request, CertificationType $certificationType)
    {
        $certificationType->update($request->validated());

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de certificación actualizado exitosamente.');
    }

    public function destroy(CertificationType $certificationType)
    {
        $certificationType->delete();

        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Tipo de certificación eliminado exitosamente.');
    }
}
