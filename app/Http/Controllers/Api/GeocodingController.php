<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Exception;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class GeocodingController extends Controller
{
    use ApiResponse;

    public function geocode(Request $request): JsonResponse
    {
        $key = 'geocoding:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return $this->error('Demasiadas solicitudes. Por favor, espere un momento.', 429);
        }
        RateLimiter::hit($key, 1);

        $addressData = [
            'street' => $request->input('street'),
            'exterior_number' => $request->input('exterior_number'),
            'postal_code' => $request->input('postal_code'),
            'neighborhood' => $request->input('neighborhood'),
            'municipality' => $request->input('municipality'),
            'state' => $request->input('state'),
        ];

        $strategies = $this->buildSearchStrategies($addressData);

        if (empty($strategies)) {
            return $this->error('Datos de dirección insuficientes para realizar la búsqueda.', 400);
        }

        foreach ($strategies as $index => $query) {
            try {
                $results = Geocoder::geocode($query)->get();

                if ($results->isNotEmpty()) {
                    $location = $results->first();
                    $coordinates = $location->getCoordinates();

                    $precision = 'approximate';

                    if ($index === 0 && !empty($addressData['street']) && $location->getStreetNumber()) {
                        $precision = 'exact';
                    } elseif ($index === 0 && !empty($addressData['street'])) {
                        $precision = 'street_level';
                    } elseif ($index <= 1 && !empty($addressData['neighborhood'])) {
                        $precision = 'neighborhood';
                    }

                    return $this->success([
                        'latitude' => $coordinates->getLatitude(),
                        'longitude' => $coordinates->getLongitude(),
                        'precision' => $precision,
                    ]);
                }
            } catch (Exception $exception) {
                continue;
            }
        }

        return $this->error('No se pudo encontrar la dirección.', 404);
    }

    private function buildSearchStrategies(array $data): array
    {
        $strategies = [];

        $street = trim(($data['street'] ?? '') . ' ' . ($data['exterior_number'] ?? ''));
        $neighborhood = $this->normalizeLocationName($data['neighborhood'] ?? '');
        $municipality = $data['municipality'] ?? '';
        $state = $data['state'] ?? '';
        $postalCode = $data['postal_code'] ?? '';

        if ($street || $neighborhood) {
            $parts = array_filter([$street, $neighborhood, $postalCode, $municipality, $state, 'México']);
            $strategies[] = implode(', ', $parts);
        }

        if ($neighborhood) {
            $parts = array_filter([$neighborhood, $postalCode, $municipality, $state, 'México']);
            $strategies[] = implode(', ', $parts);
        }

        if ($postalCode && $municipality) {
            $strategies[] = implode(', ', array_filter([$postalCode, $municipality, $state, 'México']));
        }

        if ($municipality && $state) {
            $strategies[] = "{$municipality}, {$state}, México";
        }

        return array_unique($strategies);
    }

    private function normalizeLocationName(string $name): string
    {
        if (empty($name)) {
            return '';
        }

        $name = preg_replace('/^(El|La|Los|Las|Lo)\s+/i', '', $name);
        $name = preg_replace('/\s+(Centro|Norte|Sur|Este|Oeste|Oriente|Poniente|I{1,3}|IV|V|VI{0,3}|1ra|2da|3ra|[1-9]a|Secc(?:ión)?\.?\s*\w*|Etapa\s*\w*)$/i', '', $name);
        $name = preg_replace('/^(Fracc?(?:ionamiento)?|Col(?:onia)?|U\.?\s*H\.?|Unidad\s+Habitacional|Residencial|Barrio|Ampliación|Amp\.?|Pueblo|Ejido|Rancho|Hacienda)\s+/i', '', $name);

        return trim($name);
    }
}
