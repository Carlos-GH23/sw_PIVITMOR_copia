<?php

namespace App\Http\Controllers;

use App\Http\Resources\MunicipalityResource;
use App\Http\Resources\NeighborhoodResource;
use App\Http\Resources\StateResource;
use App\Models\State;
use App\Models\Municipality;
use App\Models\Neighborhood;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use ApiResponse;

    public function getStates()
    {
        $states = State::orderBy('name')->get();
        return StateResource::collection($states);
    }

    public function getNeighborhoods(Municipality $municipality, Request $request)
    {
        $query = $municipality->neighborhoods()->orderBy('name');

        if ($request->has('postal_code')) {
            $query->where('postal_code', $request->input('postal_code'));
        }

        $neighborhoods = $query->get();
        return NeighborhoodResource::collection($neighborhoods);
    }

    public function getMunicipalities(State $state)
    {
        $municipalities = $state->municipalities()->orderBy('name')->get();
        return MunicipalityResource::collection($municipalities);
    }

    public function getPostalCode(string $postalCode)
    {
        $neighborhood = Neighborhood::where('postal_code', $postalCode)
            ->with('municipality.state')
            ->first();

        if ($neighborhood) {
            return new NeighborhoodResource($neighborhood);
        }

        return $this->error('No se encontraron coincidencias');
    }
}
