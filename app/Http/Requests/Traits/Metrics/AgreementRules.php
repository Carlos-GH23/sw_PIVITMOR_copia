<?php

namespace App\Http\Requests\Traits\Metrics;

trait AgreementRules
{
    public function agreementRules(int $limit = 255): array
    {
        return [
            'partnership_agreements'                    => ['nullable', 'array', 'max:' . $limit],
            'partnership_agreements.*.id'               => ['nullable', 'integer', 'exists:partnership_agreements,id'],
            'partnership_agreements.*.agreement_type'   => ['required', 'string', 'max:255'],
            'partnership_agreements.*.name'             => ['required', 'string', 'max:255'],
        ];
    }

    public function agreementAttributes(): array
    {
        return [
            'partnership_agreements'                    => 'acuerdos de asociación',
            'partnership_agreements.*.agreement_type'   => 'tipo de acuerdo',
            'partnership_agreements.*.name'             => 'nombre del acuerdo',
        ];
    }
}
