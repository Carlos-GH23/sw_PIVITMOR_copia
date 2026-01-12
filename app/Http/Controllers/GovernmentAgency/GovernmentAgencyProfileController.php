<?php

namespace App\Http\Controllers\GovernmentAgency;

use App\Http\Controllers\Controller;
use App\Http\Requests\GovernmentAgency\UpdateGovernmentAgencyRequest;
use Illuminate\Support\Facades\DB;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Services\ContactService;
use App\Services\GovernmentAgency\GovernmentAgencyService;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\GovernmentAgency\GovernmentLevel;
use App\Http\Resources\GovernmentAgency\GovernmentAgencyResource;
use App\Models\Catalogs\GovernmentSector;

class GovernmentAgencyProfileController extends Controller
{
    use Filterable;

    private string $routeName;
    private string $source;
    private Model $model;
    protected ContactService $contactService;
    protected GovernmentAgencyService $governmentAgencyService;

    public function __construct(GovernmentAgencyService $governmentAgencyService, ContactService $contactService)
    {
        $this->source = 'Domains/GovernmentAgency/Profile/Pages/';
        $this->model = new GovernmentAgency();
        $this->routeName = 'governmentAgency.profile.';
        $this->governmentAgencyService = $governmentAgencyService;
        $this->contactService = $contactService;

        $this->middleware('permission:governmentAgency.profile')->only(['show', 'update']);
    }

    public function edit(): Response
    {
        $user = Auth::user();
        $agency = $user->governmentAgency;
        $agency->load([
            'contact',
            'logo',
            'location.neighborhood.municipality.state',
            'phoneNumbers',
            'socialLinks',
            'keywords',
        ]);

        return Inertia::render("{$this->source}Edit", [
            'governmentAgency'        => new GovernmentAgencyResource($agency),
            'title'         => 'Mi Perfil de Dependencia de Gobierno',
            'routeName'     => $this->routeName,
            'levels'        => GovernmentLevel::orderBy('name')->get(),
            'governmentSectors'    => GovernmentSector::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateGovernmentAgencyRequest $request)
    {
        try{
        $governmentAgency = Auth::user()->governmentAgency;
        DB::transaction(function () use ($request, $governmentAgency) {
            $validatedData = $request->validated();
            $this->governmentAgencyService->updateFromRequest($validatedData, $governmentAgency);
        });
    } catch (\Exception $e) {
        return back()->with('error', 'Ocurrió un error al actualizar el perfil');
    }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
