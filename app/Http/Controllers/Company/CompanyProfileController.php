<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\UpdateCompanyProfileRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Company\Company;
use App\Models\Company\CompanySize;
use App\Models\Company\InnovationType;
use App\Models\Company\MarketReach;
use App\Models\Company\Origen;
use App\Services\CompanyProfileService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CompanyProfileController extends Controller
{
    use Filterable;

    private string $routeName;
    private string $source;
    private Model $model;
    protected CompanyProfileService $companyProfileService;

    public function __construct(CompanyProfileService $companyProfileService)
    {
        $this->source = 'Domains/Company/Profile/Pages/';
        $this->routeName = 'company.profile.';
        $this->model = new Company();
        $this->companyProfileService = $companyProfileService;

        $this->middleware("permission:company.profile")->only(['edit', 'update']);
    }

    public function edit(): Response
    {
        $company = Auth::user()->company;
        $company->load([
            'logo',
            'keywords',
            'location.neighborhood.municipality.state',
            'contact',
            'phoneNumbers',
            'socialLinks',
            'reniecyt',
            'technologyCompany',
            'technologyCompany.economicSectors',
            'technologyCompany.oecdSectors',
            'technologyCompany.files',
        ]);
        return Inertia::render("{$this->source}Edit", [
            'company'           => new CompanyResource($company),
            'title'             => 'Mi Perfil Empresarial',
            'routeName'         => $this->routeName,
            'origens'           => Origen::orderBy('name')->get(),
            'innovationTypes'   => InnovationType::orderBy('name')->get(),
            'marketReaches'     => MarketReach::orderBy('name')->get(),
            'companySizes'      => CompanySize::get(),
            'technologyLevels'  => TechnologyLevel::orderBy('name')->get(),
            'economicSectors'   => EconomicSector::getHierarchy(),
            'oecdSectors'       => OecdSector::getHierarchy(),
        ]);
    }

    public function update(UpdateCompanyProfileRequest $request)
    {
        $company = Auth::user()->company;
        try {
            $this->companyProfileService->update($company, $request->validated());
            return back()->with('success', 'Perfil actualizado correctamente.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el perfil');
        }
    }
}
