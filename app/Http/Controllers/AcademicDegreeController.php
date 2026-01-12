<?php

namespace App\Http\Controllers;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AcademicDegreeController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;

    public function __construct()
    {
        $this->routeName = "academics.academic_degrees.";
        $this->source    = "Domains/Academic/AcademicDegree/Pages/";
    }
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        // Route::get('/academic-degrees', function (Request $request) {
        //     $filters = 
        return Inertia::render("{$this->source}Index", [
            'title' => 'Formación académica',
            'routeName' => $this->routeName,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title' => 'Agregar formación académica',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
