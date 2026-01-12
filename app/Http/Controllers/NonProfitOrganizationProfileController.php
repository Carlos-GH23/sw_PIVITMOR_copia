<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateNonProfitOrganizationProfileRequest;
use App\Http\Resources\NonProfitOrganizationResource;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\LegalEntityType;
use App\Models\Company\MarketReach;
use App\Models\NonProfitOrganization;
use App\Services\NonProfitOrganizationProfileService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class NonProfitOrganizationProfileController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;
    protected NonProfitOrganizationProfileService $nonProfitOrganizationService;

    public function __construct(NonProfitOrganizationProfileService $nonProfitOrganizationService)
    {
        $this->routeName = "nonProfitOrganization.profile.";
        $this->source    = "Domains/NonProfitOrganization/Profile/Pages/";
        $this->model     = new NonProfitOrganization();
        $this->nonProfitOrganizationService = $nonProfitOrganizationService;

        $this->middleware("permission:nonProfitOrganization.profile")->only(['edit', 'update']);
    }

    public function edit()
    {
        $user = Auth::user();
        $nonProfitOrganization = $user->nonProfitOrganization;

        $nonProfitOrganization->load([
            'contact',
            'economicSector',
            'keywords',
            'legalEntityType',
            'location.neighborhood.municipality.state',
            'logo',
            'marketReach',
            'phoneNumbers',
            'socialLinks',
        ]);

        return Inertia::render("{$this->source}Edit", [
            'title'     => 'Perfil Organización No Gubernamental',
            'routeName' => $this->routeName,
            'nonProfitOrganization' => new NonProfitOrganizationResource($nonProfitOrganization),
            'economicSectors' => EconomicSector::select('id', 'name')->get(),
            'legalEntityTypes' => LegalEntityType::select('id', 'name')->get(),
            'marketReaches' => MarketReach::select('id', 'name')->get(),
        ]);
    }

    public function update(UpdateNonProfitOrganizationProfileRequest $request)
    {
        $nonProfitOrganization = Auth::user()->nonProfitOrganization;
        try {
            $this->nonProfitOrganizationService->update($nonProfitOrganization, $request->validated());
            return redirect()->route("{$this->routeName}edit")->with('success', 'Perfil actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}edit")->with('error', 'Ha ocurrido un error al actualizar el perfil');
        }
    }
}
