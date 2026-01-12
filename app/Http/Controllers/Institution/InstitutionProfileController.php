<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use App\Http\Requests\Institution\UpdateInstitutionProfileRequest;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionCategory;
use App\Models\Catalogs\KnowledgeArea;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\InstitutionType;
use App\Http\Resources\Institution\InstitutionResource;
use App\Services\InstitutionProfileService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class InstitutionProfileController extends Controller
{
    use Filterable;

    private string $routeName;
    private string $source;
    private Model $model;
    protected InstitutionProfileService $institutionProfileService;

    public function __construct(InstitutionProfileService $institutionProfileService)
    {
        $this->source = 'Domains/Institution/Profile/Pages/';
        $this->model = new Institution();
        $this->routeName = 'institution.profile.';
        $this->institutionProfileService = $institutionProfileService;

        $this->middleware("permission:institution.profile")->only(['edit', 'update']);
    }

    public function edit(): Response
    {
        $user = Auth::user();
        $institution = $user->institution;
        $institution->load([
            'logo',
            'location.neighborhood.municipality.state',
            'contact',
            'phoneNumbers',
            'socialLinks',
            'reniecyt',
            'oecdSectors',
            'knowledgeAreas',
            'economicSectors',
            'institutionType.institutionCategory',
            'keywords',
        ]);
        return Inertia::render("{$this->source}Edit", [
            'institution'   => new InstitutionResource($institution),
            'title'         => 'Mi Perfil Institucional',
            'routeName'     => $this->routeName,
            'categories'    => InstitutionCategory::orderBy('name')->get(),
            'types'         => InstitutionType::orderBy('name')->get(),
            'knowledges'    => KnowledgeArea::orderBy('name')->with('children')->whereNull('parent_id')->get(),
            'oecdSectors'   => OecdSector::getHierarchy(),
            'economicSectors' => EconomicSector::getHierarchy(),
        ]);
    }

    public function update(UpdateInstitutionProfileRequest $request)
    {
        $institution = Auth::user()->institution;
        try {
            $this->institutionProfileService->update($institution, $request->validated());
            return back()->with('success', 'Perfil actualizado correctamente.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el perfil');
        }
    }
}
