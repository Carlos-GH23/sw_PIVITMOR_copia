<?php

namespace App\Http\Requests\Traits\Metrics;

trait TestimonialRules
{
    public function testimonialRules(int $limit = 5): array
    {
        return [
            'testimonials'                 => ['nullable', 'array', 'max:' . $limit],
            'testimonials.*.id'            => ['nullable', 'integer', 'exists:testimonials,id'],
            'testimonials.*.name'          => ['required', 'nullable', 'string', 'max:255'],
            'testimonials.*.position'      => ['required', 'nullable', 'string', 'max:255'],
            'testimonials.*.testimonial'   => ['required', 'nullable', 'string', 'max:2000'],
        ];
    }

    public function testimonialAttributes(): array
    {
        return [
            'testimonials'                  => 'testimonios',
            'testimonials.*.id'             => 'id',
            'testimonials.*.name'           => 'nombre',
            'testimonials.*.position'       => 'posición',
            'testimonials.*.testimonial'    => 'testimonio',
        ];
    }
}
