<?php

namespace App\Http\Requests\Notice;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\PhotoRules;

class StoreNoticeRequest extends FormRequest
{
    use PhotoRules;
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
        $isDraft = (bool) $this->input('is_draft', false);

        $statusBasedRule = $isDraft ? 'nullable' : 'required';

        return
            [
                'title'        => ['required', 'max:150', 'string'],
                'subtitle'     => ['nullable', 'max:150', 'string'],
                'abstract'     => ['nullable', 'string', 'max:1000'],
                'notice_body'   => [$statusBasedRule, 'string', 'max:50000'],
                'notice_source' => ['nullable', 'string', 'max:255'],
                'photo' => [$statusBasedRule, 'array'],
                'photo.file' => [$statusBasedRule, 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                'photo.description' => ['nullable', 'string', 'max:255'],
                'author'       => [$statusBasedRule, 'string', 'max:100'],
                'creation_date' => [$statusBasedRule, 'date'],
                'publication_date' => ['nullable', 'date'],
                'email_notification' => ['nullable'],

                'news_category_id' => [$statusBasedRule, 'integer', 'exists:news_categories,id'],
                'notice_status_id' => [$statusBasedRule, 'integer', 'exists:notice_statuses,id'],

                'keywords' => [$statusBasedRule, 'array'],
                'keywords.*.name' => ['required_with:keywords', 'string', 'max:50'],
            ];
    }

    public function attributes(): array
    {
        return
            [
                'title' => 'título',
                'subtitle' => 'subtítulo',
                'abstract' => 'resumen',
                'notice_body' => 'cuerpo de la noticia',
                'notice_source' => 'fuente de la noticia',
                'photo' => 'foto',
                'photo.file'        => 'imagen',
                'photo.description' => 'descripción',
                
                'author' => 'autor',
                'creation_date' => 'fecha de creación',
                'publication_date' => 'fecha de publicación',
                'email_notification' => 'notificación por correo electrónico',

                'news_category_id' => 'categoría de la noticia',
                'notice_status_id' => 'estatus de la noticia',

                'keywords' => 'palabras clave',
                'keywords.*.name' => 'nombre de la palabra clave',
            ];
    }
}
