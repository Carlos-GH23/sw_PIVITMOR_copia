<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rule;

trait PhoneNumberRules
{
    protected function phoneNumberRules(): array
    {
        return [
            'phones'                => ['nullable', 'array'],
            'phones.*.id'           => ['nullable', 'integer', 'exists:phone_numbers,id'],
            'phones.*.number'       => ['required', 'string', 'digits:10', 'distinct'],
            'phones.*.dial_code'    => ['nullable', 'string', 'max:10'],
            'phones.*.type'         => ['required', 'string', Rule::in(['oficina', 'celular', 'casa', 'fax'])],
        ];
    }

    protected function phoneNumberAttributes(): array
    {
        return [
            'phones'                => 'teléfonos',
            'phones.*.id'           => 'id',
            'phones.*.number'       => 'número de teléfono',
            'phones.*.dial_code'    => 'código de país',
            'phones.*.type'         => 'tipo de teléfono',
        ];
    }
}
