<?php

namespace App\Http\Requests\AcademicGroups;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\FileValidationRules;

class StoreResearchLineRequest extends FormRequest
{
    use FileValidationRules;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge([
            'logo' => 'nullable',
            'logo.id' => 'nullable|integer|exists:photos,id',
            'logo.file' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo.delete_photo' => 'boolean',

            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'max:2000', 'string'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'academics' => ['required', 'array', 'min:1'],
            'academics.*' => ['required', 'integer', 'exists:academics,id'],
            'oecd_sectors' => ['required', 'array', 'min:1'],
            'oecd_sectors.*' => ['required', 'integer', 'exists:oecd_sectors,id'],
            'economic_sectors' => ['required', 'array', 'min:1'],
            'economic_sectors.*' => ['required', 'integer', 'exists:economic_sectors,id'],

            'keywords' => ['required', 'array', 'min:1'],
            'keywords.*.name' => ['required', 'string', 'max:255'],
        ], $this->filesRules());
    }

    public function attributes(): array
    {
        return array_merge([
            'logo' => 'logo',
            'name' => 'nombre',
            'description' => 'reseña',
            'department_id' => 'departamento',
            'academics' => 'profesores',
            'academics.*' => 'profesor',
            'oecd_sectors' => 'sectores',
            'oecd_sectors.*' => 'sector',
            'economic_sectors' => 'sectores económicos',
            'economic_sectors.*' => 'sector económico',
            'keywords' => 'topicos de investigación',
            'keywords.*.name' => 'topico de investigación',
        ], $this->filesAttributes());
    }
}
