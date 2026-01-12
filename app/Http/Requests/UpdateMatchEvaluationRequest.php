<?php

namespace App\Http\Requests;

use App\Enums\TerritoryLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\Traits\Metrics\AgreementRules;
use App\Http\Requests\Traits\Metrics\ImpactMetricRules;
use App\Http\Requests\Traits\Metrics\MetricIndicatorRules;
use App\Http\Requests\Traits\Metrics\ParticipationRules;
use App\Http\Requests\Traits\Metrics\PolicyRules;
use App\Http\Requests\Traits\Metrics\RecognitionRules;
use App\Http\Requests\Traits\Metrics\TestimonialRules;
use App\Http\Requests\Traits\Metrics\TransitionRules;

class UpdateMatchEvaluationRequest extends FormRequest
{
    use ImpactMetricRules;
    use MetricIndicatorRules;
    use TestimonialRules;
    use PolicyRules;
    use AgreementRules;
    use ParticipationRules;
    use RecognitionRules;
    use TransitionRules;

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
        $statusBasedRule = (int)$this->input('match_evaluation_status_id') === 1 ? 'nullable' : 'required';

        return array_merge(
            [
                'title'                                         => ['required', 'string', 'max:255'],
                'description'                                   => [$statusBasedRule, 'string', 'max:2000'],
                'start_date'                                    => [$statusBasedRule, 'date'],
                'end_date'                                      => [$statusBasedRule, 'date', 'after_or_equal:start_date'],
                'story'                                         => [$statusBasedRule, 'string', 'max:2000'],
                'results'                                       => [$statusBasedRule, 'string', 'max:2000'],
                'goals'                                         => [$statusBasedRule, 'string', 'max:2000'],
                'lessons'                                       => [$statusBasedRule, 'string', 'max:2000'],
                'categories'                                    => [$statusBasedRule, 'array'],
                'categories.*'                                  => ['integer', 'exists:match_evaluation_categories,id'],
                'match_evaluation_status_id'                    => ['required', 'integer', 'exists:match_evaluation_statuses,id'],

                'training_hours'                                => ['nullable', 'integer', 'min:0', 'max:100000'],
                'economic_estimate'                             => ['nullable', 'numeric', 'min:0', 'max:10000000'],
                'productivity_increase'                         => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'territorial_level'                             => ['nullable', 'string', Rule::in(TerritoryLevel::values())],
                'emissions_percentage'                          => ['nullable', 'string', 'max:255'],
                'emissions_methodology'                         => ['nullable', 'string', 'max:255'],
                'community_impact_level'                        => ['nullable', 'string', 'max:255'],
                'inclusion_equity_level'                        => ['nullable', 'string', 'max:255'],
                'project_sustainability_status'                 => ['nullable', 'string', 'max:255'],
                'rating'                                        => ['nullable', 'integer', 'min:1', 'max:5'],
                'continuity_percentage'                         => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'continuity_type'                               => ['nullable', 'string', 'max:255'],
                'communication_management_percentage'           => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'infrastructure_level'                          => ['nullable', 'string', 'max:255'],
                'estimated_investment'                          => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'maturity_level'                                => ['nullable', 'integer', 'min:1', 'max:5'],
                'structure_type'                                => ['nullable', 'string', 'max:255'],
                'public_service_percentage'                     => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'transparency_level'                            => ['nullable', 'string', 'max:255'],
                'academic_offerings'                            => ['nullable', 'array'],
                'academic_offerings.*'                          => ['integer', 'exists:academic_offerings,id'],
                'process_digitalization_percentage'             => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'process_simplification_percentage'             => ['nullable', 'numeric', 'min:0', 'max:100000'],
                'interoperability_level'                        => ['nullable', 'string', 'max:255'],
            ],
            $this->impactMetricRules(),
            $this->metricIndicatorRules(),
            $this->testimonialRules(),
            $this->policyRules(),
            $this->agreementRules(),
            $this->participationRules(),
            $this->recognitionRules(),
            $this->transitionRules(),
        );
    }

    public function attributes(): array
    {
        return array_merge(
            [
                'title'                                     => 'título',
                'description'                               => 'descripción',
                'start_date'                                => 'fecha de inicio',
                'end_date'                                  => 'fecha de fin',
                'story'                                     => 'historia',
                'results'                                   => 'resultados',
                'goals'                                     => 'metas',
                'lessons'                                   => 'lecciones aprendidas',
                'categories'                                => 'categorías',
                'categories.*'                              => 'categoría',
                'match_evaluation_status_id'                => 'estatus de la evaluación',

                'training_hours'                            => 'horas de capacitación',
                'economic_estimate'                         => 'valor económico estimado',
                'productivity_increase'                     => 'incremento de productividad',
                'territorial_level'                         => 'territorio o región',
                'emissions_percentage'                      => 'porcentaje de emisiones',
                'emissions_methodology'                     => 'metodología de emisiones',
                'community_impact_level'                    => 'nivel de impacto comunitario',
                'inclusion_equity_level'                    => 'nivel de inclusión y equidad',
                'project_sustainability_status'             => 'estado de sostenibilidad del proyecto',
                'rating'                                    => 'calificación',
                'continuity_percentage'                     => 'porcentaje de continuidad',
                'continuity_type'                           => 'tipo de continuidad',
                'communication_management_percentage'       => 'porcentaje de gestión de comunicación',
                'infrastructure_level'                      => 'nivel de infraestructura',
                'estimated_investment'                      => 'valor estimado de inversión',
                'maturity_level'                            => 'nivel de madurez',
                'structure_type'                            => 'tipo de estructura',
                'academic_offerings'                        => 'programas académicos vinculados',
                'process_digitalization_percentage'         => 'porcentaje de digitalización',
                'process_simplification_percentage'         => 'porcentaje de simplificación',
                'interoperability_level'                    => 'nivel de interoperabilidad',
            ],
            $this->impactMetricAttributes(),
            $this->metricIndicatorAttributes(),
            $this->testimonialAttributes(),
            $this->policyAttributes(),
            $this->agreementAttributes(),
            $this->participationAttributes(),
            $this->recognitionAttributes(),
            $this->transitionAttributes(),
        );
    }
}
