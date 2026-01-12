<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rule;

trait ContactRules
{
    protected function contactRules(): array
    {
        return [
            'contact'           => 'array',
            'contact.id'        => 'nullable|integer|exists:contacts,id',
            'contact.name'      => 'nullable|string|max:255',
            'contact.email'     =>  ['nullable', 'email', 'max:255'],
            'contact.website'   => 'nullable|url',
        ];
    }

    protected function contactAttributes(): array
    {
        return [
            'contact'           => 'contacto',
            'contact.name'      => 'nombre',
            'contact.email'     => 'correo electrónico',
            'contact.website'   => 'página web',
        ];
    }
}
