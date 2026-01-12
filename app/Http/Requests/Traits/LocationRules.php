<?php

namespace App\Http\Requests\Traits;

trait LocationRules
{
    protected function locationRules(): array
    {
        return [
            'location.state_id'         => ['nullable', 'exists:states,id'],
            'location.municipality_id'  => ['nullable', 'exists:municipalities,id'],
            'location.neighborhood_id'  => ['nullable', 'exists:neighborhoods,id'],
            'location.postal_code'      => ['nullable', 'string', 'digits:5', 'exists:neighborhoods,postal_code'],
            'location.street'           => ['nullable', 'string', 'max:255'],
            'location.exterior_number'  => ['nullable', 'string', 'max:50'],
            'location.interior_number'  => ['nullable', 'string', 'max:50'],
            'location.latitude'         => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude'        => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    protected function locationAttributes(): array
    {
        return [
            'location.state_id'         => 'estado',
            'location.municipality_id'  => 'municipio',
            'location.neighborhood_id'  => 'colonia',
            'location.postal_code'      => 'código postal',
            'location.street'           => 'calle',
            'location.exterior_number'  => 'número exterior',
            'location.interior_number'  => 'número interior',
            'location.latitude'         => 'latitud',
            'location.longitude'        => 'longitud',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $location = $this->input('location', []);
            $hasAnyLocationField = collect($location)->filter()->isNotEmpty();

            if ($hasAnyLocationField) {
                $requiredFields = [
                    'postal_code'       => 'código postal',
                    'municipality_id'   => 'municipio',
                    'neighborhood_id'   => 'colonia',
                    'street'            => 'calle',
                    'exterior_number'   => 'número exterior',
                ];

                foreach ($requiredFields as $field => $label) {
                    if (empty($location[$field])) {
                        $validator->errors()->add(
                            "location.{$field}",
                            "El campo {$label} es obligatorio cuando se proporciona información de ubicación."
                        );
                    }
                }

                if (empty($location['latitude']) || empty($location['longitude'])) {
                    $validator->errors()->add("location.latitude", "Debes agregar un marcador en el mapa.");
                    $validator->errors()->add("location.longitude",  "Debes agregar un marcador en el mapa.");
                }
            }
        });
    }
}
