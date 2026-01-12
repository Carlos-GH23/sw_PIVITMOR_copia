<?php

namespace App\Http\Requests\Traits\Metrics;

trait RecognitionRules
{
    public function recognitionRules(int $limit = 255): array
    {
        return [
            'recognitions'                      => ['nullable', 'array', 'max:' . $limit],
            'recognitions.*.id'                 => ['nullable', 'integer', 'exists:institutional_recognitions,id'],
            'recognitions.*.name'               => ['required', 'string', 'max:255'],
            'recognitions.*.recognized_at'      => ['required', 'date'],
            'recognitions.*.url'                => ['required', 'string', 'max:255'],
        ];
    }

    public function recognitionAttributes(): array
    {
        return [
            'recognitions'                      => 'reconocimientos',
            'recognitions.*.name'               => 'nombre del reconocimiento',
            'recognitions.*.recognized_at'      => 'fecha de reconocimiento',
            'recognitions.*.url'                => 'url del reconocimiento',
        ];
    }
}
