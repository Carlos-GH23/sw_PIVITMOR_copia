<?php

namespace App\Http\Requests\Catalogs;

use App\Enums\EconomicSectorLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEconomicSectorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => [
                'required',
                'string',
                'max:255',
                // This rule ensures the name is unique within its parent.
                // It allows for duplicate names if they have different parents.
                Rule::unique('economic_sectors', 'name')->where(function ($query) {
                    $query->where('parent_id', $this->parent_id);
                }),
            ],
            'level' => [
                'required',
                'string',
                Rule::in(array_column(EconomicSectorLevel::cases(), 'value')),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:economic_sectors,id',
                Rule::requiredIf(fn() => in_array($this->level, [EconomicSectorLevel::DIVISION->value, EconomicSectorLevel::GROUP->value]))
            ],
            'economic_social_sector_id' => [
                'nullable',
                'integer',
                'exists:economic_social_sectors,id'
            ],
        ];
    }

    /**
     * Get the custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $attributes = [
            'name'                      => 'nombre',
            'level'                     => 'nivel',
            'economic_social_sector_id' => 'sector social económico',
        ];

        if ($this->level === EconomicSectorLevel::DIVISION->value) {
            $attributes['parent_id'] = 'sección';
        } elseif ($this->level === EconomicSectorLevel::GROUP->value) {
            $attributes['parent_id'] = 'división';
        } else {
            $attributes['parent_id'] = 'sector padre';
        }

        return $attributes;
    }
}
