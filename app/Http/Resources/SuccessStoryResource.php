<?php

namespace App\Http\Resources;

use App\Enums\MetricIndicatorType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'title'                     => $this->title,
            'description'               => $this->description,
            'story'                     => $this->story,
            'rating'                    => $this->rating,
            'category'                  => $this->categories?->first()?->parent?->name,
            'actors'                    => $this->match->actors(),
            'first_testimonial'         => $this->testimonials?->first(),
            'testimonials'              => $this->testimonials,
            'productivity_increase'     => $this->productivity_increase,
            'indicator_productivity_increase'    => $this->metricIndicators->where('type', MetricIndicatorType::ProductivityIncreases)?->first(),
            'indicator_linking_satisfaction'      => $this->metricIndicators->where('type', MetricIndicatorType::LinkingSatisfaction)?->first(),
        ];
    }
}
