<?php

namespace App\Enums;

enum ImpactMetricType: string
{
    case ScientificTechnological = 'scientific_technological';
    case Economic = 'economic';
    case Institutional = 'institutional';
    case SocialEnvironmental = 'social_environmental';
    case PerceptionSatisfaction = 'perception_satisfaction';
    case PublicInnovation = 'public_innovation';

    case TechnologicalTransfers = 'technological_transfer_metrics';
    case Audiences = 'audiences';
    case SustainableDevelopmentGoals = 'sustainable_development_goals';

    public function label(): string
    {
        return match ($this) {
            self::ScientificTechnological => 'Científico-tecnológicas',
            self::Economic => 'Económicas',
            self::Institutional => 'Institucionales',
            self::SocialEnvironmental => 'Sociales y ambientales',
            self::PerceptionSatisfaction => 'Percepción y satisfacción',
            self::PublicInnovation => 'Gobierno e innovación pública',

            self::TechnologicalTransfers => 'Transferencias tecnológicas',
            self::Audiences => 'Audiencias',
            self::SustainableDevelopmentGoals => 'Objetivos de Desarrollo Sostenible (ODS) relacionados',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ScientificTechnological => 'green',
            self::Economic => 'yellow',
            self::Institutional => 'gray',
            self::SocialEnvironmental => 'forest',
            self::PerceptionSatisfaction => 'wine',
            self::PublicInnovation => 'red',

            self::TechnologicalTransfers => 'green',
            self::Audiences => 'yellow',
            self::SustainableDevelopmentGoals => 'forest',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(
            fn(self $type) => [
                'value' => $type->value,
                'label' => $type->label(),
            ],
            self::cases()
        );
    }

    public static function valuesMatchingLabel(string $search): array
    {
        $search = mb_strtolower($search);

        return array_map(
            fn(self $type) => $type->value,
            array_filter(
                self::cases(),
                fn(self $type) =>
                str_contains(mb_strtolower($type->label()), $search)
            )
        );
    }
}
