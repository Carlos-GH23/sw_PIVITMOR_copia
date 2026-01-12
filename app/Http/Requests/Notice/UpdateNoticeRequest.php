<?php

namespace App\Http\Requests\Notice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isDraft = (bool) $this->input('is_draft', false);

        $statusBasedRule = $isDraft ? 'nullable' : 'required';

        return
            [
                'title'        => ['required', 'max:150','string'],
                'subtitle'     => ['nullable', 'max:150', 'string'],
                'abstract'     => ['nullable', 'string', 'max:1000'],
                'notice_body'   => [$statusBasedRule, 'string', 'max:50000'],
                'notice_source' => ['nullable', 'string', 'max:255'],
                'photo' => ['nullable', 'array'],
                'photo.id' => ['nullable', 'integer', 'exists:photos,id'],
                'photo.file' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                'photo.description' => ['nullable', 'string', 'max:255'],
                'photo.delete_photo' => ['boolean'],
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
                'title'        => 'título',
                'subtitle'     => 'subtítulo',
                'abstract'     => 'resumen',
                'noticeBody'   => 'cuerpo de la noticia',
                'noticeSource' => 'fuente de la noticia',
                'photo' => 'foto',
                'photo.file'        => 'archivo',
                'photo.description' => 'descripción',
                'author'       => 'autor',
                'creationDate' => 'fecha de creación',
                'publicationDate' => 'fecha de publicación',
                'emailNotification' => 'notificación por correo',

                'news_category_id' => 'categoría',
                'notice_status_id' => 'estado',

                'keywords' => 'palabras clave',
                'keywords.*.name' => 'palabra clave',
            ];
    }
}
