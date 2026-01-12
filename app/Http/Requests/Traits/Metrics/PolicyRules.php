<?php

namespace App\Http\Requests\Traits\Metrics;

trait PolicyRules
{
    public function policyRules(int $limit = 255): array
    {
        return [
            'derived_policies'                  => ['nullable', 'array', 'max:' . $limit],
            'derived_policies.*.id'             => ['nullable', 'integer', 'exists:derived_policies,id'],
            'derived_policies.*.status'         => ['required', 'string', 'max:255'],
            'derived_policies.*.date'           => ['required', 'date'],
            'derived_policies.*.url'            => ['required', 'url'],
            'derived_policies.*.description'    => ['required', 'string', 'max:255'],
        ];
    }

    public function policyAttributes(): array
    {
        return [
            'derived_policies'                  => 'políticas derivadas',
            'derived_policies.*.status'         => 'estatus',
            'derived_policies.*.date'           => 'fecha',
            'derived_policies.*.url'            => 'url',
            'derived_policies.*.description'    => 'descripción',
        ];
    }
}
