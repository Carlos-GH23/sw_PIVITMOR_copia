<?php

namespace App\Http\Requests\Catalogs;

use App\Enums\OecdLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOecdSectorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'parent_id' => [
                'nullable',
                'exists:oecd_sectors,id',
                Rule::requiredIf(fn() => in_array($this->level, [OecdLevel::SUBAREA->value, OecdLevel::DISCIPLINE->value]))
            ],
            'economic_social_sector_id' => ['nullable', 'exists:economic_social_sectors,id'],
            'level'     => ['required', Rule::enum(OecdLevel::class)],
        ];
    }

    public function attributes(): array
    {
        $attributes = [
            'name'                      => 'nombre',
            'economic_social_sector_id' => 'sector económico-social',
            'level'                     => 'nivel',
        ];

        if ($this->level === OecdLevel::SUBAREA->value) {
            $attributes['parent_id'] = 'área principal';
        } elseif ($this->level === OecdLevel::DISCIPLINE->value) {
            $attributes['parent_id'] = 'subárea';
        } else {
            $attributes['parent_id'] = 'padre';
        }

        return $attributes;
    }
}
