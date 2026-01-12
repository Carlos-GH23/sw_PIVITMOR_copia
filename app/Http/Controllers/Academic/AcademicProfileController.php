<?php

namespace App\Http\Controllers\Academic;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\UpdateAcademicProfileRequest;
use App\Http\Resources\Institution\AcademicResource;
use App\Models\Academic;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Institution\Department;
use App\Models\Institution\SniLevel;
use App\Models\ResearchArea;
use App\Services\AcademicProfileService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AcademicProfileController extends Controller
{
    use Filterable;

    private string $routeName;
    private string $source;
    private Model $model;
    protected AcademicProfileService $academicProfileService;

    public function __construct(AcademicProfileService $academicProfileService)
    {
        $this->source = 'Domains/Academic/Profile/Pages/';
        $this->routeName = 'academic.profile.';
        $this->model = new Academic();
        $this->academicProfileService = $academicProfileService;

        $this->middleware("permission:academic.profile")->only(['edit', 'update']);
    }

    public function edit(): Response
    {
        $user = Auth::user();
        $academic = $user->academic;
        $academic->load([
            'photo',
            'location.neighborhood.municipality.state',
            'contact',
            'phoneNumbers',
            'socialLinks',
            'department.institution',
            'researchLines',
            'academicBodies.consolidationDegree',
            'knowledgeLines',
            'sniMembership.researchArea',
            'desirableProfile',
            'oecdSectors',
            'economicSectors',
        ]);
        return Inertia::render("{$this->source}Edit", [
            'academic'      => new AcademicResource($academic),
            'title'         => 'Mi Perfil Académico',
            'routeName'     => $this->routeName,
            'departments'   => Department::orderBy('name')->get(['id', 'name']),
            'researchAreas' => ResearchArea::select('id', 'name')->orderBy('order')->get(),
            'oecdSectors'   => OecdSector::getHierarchy(),
            'economicSectors'   => EconomicSector::getHierarchy(),
            'sniiLevels'        => SniLevel::select('id', 'name')->get(),
            'genders'   => Gender::toSelectArray(),
        ]);
    }

    public function update(UpdateAcademicProfileRequest $request)
    {
        $academic = Auth::user()->academic;
        try {
            $this->academicProfileService->update($academic, $request->validated());
            return back()->with('success', 'Perfil actualizado correctamente.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el perfil');
        }
    }
}
