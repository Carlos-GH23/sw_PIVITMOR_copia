<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuccessStoryResource;
use App\Models\MatchEvaluation;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class SuccessStoryController extends Controller
{
    protected string $source;
    protected Model $model;

    public function __construct()
    {
        $this->model     = new MatchEvaluation();
        $this->source    = "Interface/Welcome/Pages/";
    }

    public function index()
    {
        $successStories = MatchEvaluation::query()->with(['categories'])
            ->where('is_success_story', true)
            ->orderBy('rating', 'desc')->paginate(3);

        return Inertia::render("{$this->source}SuccessStories", [
            'title'          => 'Casos de Éxito',
            'successStories' => SuccessStoryResource::collection($successStories) ,
        ]);
    }

    public function show() {}
}
