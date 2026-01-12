<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\StoreProductiveEconomicSectorRequest;
use App\Http\Requests\Catalogs\UpdateProductiveEconomicSectorRequest;
use App\Http\Resources\Catalogs\ProductiveEconomicSectorResource;
use App\Models\Catalogs\ProductiveEconomicSector;
use App\Traits\Filterable;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductiveEconomicSectorController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/ProductiveEconomicSector/';
        $this->model = new ProductiveEconomicSector();
        $this->routeName = 'productiveEconomicSectors.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
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

        $productiveEconomicSectors = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'                     => 'Catálogo ISIC',
            'productiveEconomicSectors' => ProductiveEconomicSectorResource::collection($productiveEconomicSectors),
            'filters'                   => $filters,
            'routeName'                 => $this->routeName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Agregar sector económico y productivo',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductiveEconomicSectorRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector económico y productivo creado con éxito');
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
    public function edit(ProductiveEconomicSector $productiveEconomicSector)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'                     => 'Editar sector económico y productivo',
            'routeName'                 => $this->routeName,
            'productiveEconomicSector'  => new ProductiveEconomicSectorResource($productiveEconomicSector),
        ]);   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductiveEconomicSectorRequest $request, ProductiveEconomicSector $productiveEconomicSector)
    {
        $productiveEconomicSector->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Sector económico y productivo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductiveEconomicSector $productiveEconomicSector)
    {
        $productiveEconomicSector->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Sector económico y productivo eliminado con éxito");
    }
}
