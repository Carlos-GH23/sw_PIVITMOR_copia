<?php

namespace App\Http\Requests\Traits;

use Illuminate\Validation\Rule;

trait SocialLinkRules
{
    protected function socialLinkRules(): array
    {
        return [
            'social_links'           => ['nullable', 'array'],
            'social_links.*.id'      => ['nullable', 'integer', 'exists:social_links,id'],
            'social_links.*.url'     => ['required', 'url', 'distinct'],
            'social_links.*.type'    => ['required', 'string', Rule::in(['instagram', 'facebook', 'x', 'tiktok', 'linkedin', 'youtube'])
            ],
        ];
    }

    protected function socialLinkAttributes(): array
    {
        return [
            'social_links'           => 'redes sociales',
            'social_links.*.id'      => 'id',
            'social_links.*.url'     => 'url',
            'social_links.*.type'    => 'tipo',
        ];
    }
}
