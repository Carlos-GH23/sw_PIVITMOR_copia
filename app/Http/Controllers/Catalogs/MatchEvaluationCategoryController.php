<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\MatchEvaluationCategory;
use App\Http\Requests\Catalogs\StoreMatchEvaluationCategoryRequest;
use App\Http\Requests\Catalogs\UpdateMatchEvaluationCategoryRequest;
use App\Http\Resources\MatchEvaluationCategoryResource;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MatchEvaluationCategoryController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Catalogs/MatchEvaluationCategory/';
        $this->model = new MatchEvaluationCategory();
        $this->routeName = 'matchEvaluationCategories.';

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
        $query = $this->model->with('children')->isParent()
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });

        $categories = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'             => 'Catálogo de categorías de evaluación',
            'categories'        => MatchEvaluationCategoryResource::collection($categories),
            'filters'           => $filters,
            'routeName'         => $this->routeName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar categoría',
            'routeName' => $this->routeName,
            'parents' => MatchEvaluationCategory::getHierarchy(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchEvaluationCategoryRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Categoría creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchEvaluationCategory $matchEvaluationCategory)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchEvaluationCategory $matchEvaluationCategory)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'         => 'Editar categoría',
            'routeName'     => $this->routeName,
            'category'      => new MatchEvaluationCategoryResource($matchEvaluationCategory),
            'parents'       => MatchEvaluationCategory::getHierarchy(except: $matchEvaluationCategory->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchEvaluationCategoryRequest $request, MatchEvaluationCategory $matchEvaluationCategory)
    {
        $matchEvaluationCategory->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Categoría actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchEvaluationCategory $matchEvaluationCategory)
    {
        $matchEvaluationCategory->delete();
        return redirect()->route("{$this->routeName}index")->with('success', "Categoría eliminada con éxito");
    }
}
