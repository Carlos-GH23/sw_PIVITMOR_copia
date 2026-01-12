<?php

namespace App\Http\Controllers;


use App\Models\Faq;
use App\Http\Resources\FaqResource;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Traits\Filterable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Faq $model;

    public function __construct()
    {
        $this->routeName = "faqs.";
        $this->source    = "Core/Admin/Contents/Faqs/";
        $this->model     = new Faq();

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
        $faqs = Faq::query()
            ->when($filters->search, function ($q) use ($filters) {
                $q->where('question', 'like', "%{$filters->search}%")
                  ->orWhere('answer', 'like', "%{$filters->search}%");
            })
            ->orderBy($filters->order ?? 'created_at', $filters->direction ?? 'desc')
            ->paginate($filters->rows)
            ->withQueryString();
        return Inertia::render("{$this->source}Index", [
            'title' => 'Preguntas Frecuentes',
            'routeName' => $this->routeName,
            'filters' => $filters,
            'faqs' => FaqResource::collection($faqs),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar pregunta frecuente',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        $faq = Faq::create($request->validated());
        return redirect()->route($this->routeName . 'index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq): Response
    {
        return Inertia::render("{$this->source}Edit", [
            'title' => 'Editar pregunta frecuente',
            'routeName' => $this->routeName,
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());
        return redirect()->route($this->routeName . 'index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route($this->routeName . 'index');
    }
}
