<?php

namespace App\Http\Requests\Traits\Metrics;

use App\Enums\MetricIndicatorType;
use Illuminate\Validation\Rule;

trait MetricIndicatorRules
{
    protected function metricIndicatorRules(): array
    {
        return [
            // scientific
            'joint_publications'                            => ['nullable', 'array', 'max:255'],
            'joint_publications.*.name'                     => ['required_with:joint_publications', 'string', 'max:255'],
            'joint_publications.*.type'                     => ['required_with:joint_publications', 'string', Rule::in([MetricIndicatorType::JointPublications])],

            'patents'                                       => ['nullable', 'array', 'max:255'],
            'patents.*.name'                                => ['required_with:patents', 'string', 'max:255'],
            'patents.*.type'                                => ['required_with:patents', 'string', Rule::in([MetricIndicatorType::Patents])],

            'prototypes'                                    => ['nullable', 'array', 'max:255'],
            'prototypes.*.name'                             => ['required_with:prototypes', 'string', 'max:255'],
            'prototypes.*.type'                             => ['required_with:prototypes', 'string', Rule::in([MetricIndicatorType::Prototypes])],

            'registered_software'                           => ['nullable', 'array', 'max:255'],
            'registered_software.*.name'                    => ['required_with:registered_software', 'string', 'max:255'],
            'registered_software.*.type'                    => ['required_with:registered_software', 'string', Rule::in([MetricIndicatorType::RegisteredSoftware])],

            'technological_transfer_indicators'             => ['nullable', 'array', 'max:255'],
            'technological_transfer_indicators.*.name'      => ['required_with:technological_transfer_indicators', 'string', 'max:255'],
            'technological_transfer_indicators.*.type'      => ['required_with:technological_transfer_indicators', 'string', Rule::in([MetricIndicatorType::TechnologicalTransfers])],

            'knowledge_training'                            => ['nullable', 'array', 'max:255'],
            'knowledge_training.*.name'                     => ['required_with:knowledge_training', 'string', 'max:255'],
            'knowledge_training.*.type'                     => ['required_with:knowledge_training', 'string', Rule::in([MetricIndicatorType::KnowledgeTraining])],
            // economic
            'economic_estimates'                            => ['nullable', 'array', 'max:255'],
            'economic_estimates.*.name'                     => ['required_with:economic_estimates', 'string', 'max:255'],
            'economic_estimates.*.type'                     => ['required_with:economic_estimates', 'string', Rule::in([MetricIndicatorType::EconomicStimates])],

            'direct_jobs_generated'                         => ['nullable', 'array', 'max:255'],
            'direct_jobs_generated.*.name'                  => ['required_with:direct_jobs_generated', 'string', 'max:255'],
            'direct_jobs_generated.*.type'                  => ['required_with:direct_jobs_generated', 'string', Rule::in([MetricIndicatorType::DirectJobsGenerated])],

            'indirect_jobs_generated'                       => ['nullable', 'array', 'max:255'],
            'indirect_jobs_generated.*.name'                => ['required_with:indirect_jobs_generated', 'string', 'max:255'],
            'indirect_jobs_generated.*.type'                => ['required_with:indirect_jobs_generated', 'string', Rule::in([MetricIndicatorType::IndirectJobsGenerated])],

            'productivity_increases'                        => ['nullable', 'array', 'max:255'],
            'productivity_increases.*.name'                 => ['required_with:productivity_increases', 'string', 'max:255'],
            'productivity_increases.*.type'                 => ['required_with:productivity_increases', 'string', Rule::in([MetricIndicatorType::ProductivityIncreases])],

            'products'                                      => ['nullable', 'array', 'max:255'],
            'products.*.name'                               => ['required_with:products', 'string', 'max:255'],
            'products.*.type'                               => ['required_with:products', 'string', Rule::in([MetricIndicatorType::Products])],

            'services'                                      => ['nullable', 'array', 'max:255'],
            'services.*.name'                               => ['required_with:services', 'string', 'max:255'],
            'services.*.type'                               => ['required_with:services', 'string', Rule::in([MetricIndicatorType::Services])],

            'territorial_regional'                          => ['nullable', 'array', 'max:255'],
            'territorial_regional.*.name'                   => ['required_with:territorial_regional', 'string', 'max:255'],
            'territorial_regional.*.type'                   => ['required_with:territorial_regional', 'string', Rule::in([MetricIndicatorType::TerritorialRegional])],
            // social and environmentals
            'direct_beneficiaries'                          => ['nullable', 'array', 'max:255'],
            'direct_beneficiaries.*.name'                   => ['required_with:direct_beneficiaries', 'string', 'max:255'],
            'direct_beneficiaries.*.type'                   => ['required_with:direct_beneficiaries', 'string', Rule::in([MetricIndicatorType::DirectBeneficiaries])],

            'indirect_beneficiaries'                        => ['nullable', 'array', 'max:255'],
            'indirect_beneficiaries.*.name'                 => ['required_with:indirect_beneficiaries', 'string', 'max:255'],
            'indirect_beneficiaries.*.type'                 => ['required_with:indirect_beneficiaries', 'string', Rule::in([MetricIndicatorType::IndirectBeneficiaries])],

            'carbon_emissions'                              => ['nullable', 'array', 'max:255'],
            'carbon_emissions.*.name'                       => ['required_with:carbon_emissions', 'string', 'max:255'],
            'carbon_emissions.*.type'                       => ['required_with:carbon_emissions', 'string', Rule::in([MetricIndicatorType::CarbonEmissions])],

            'community_impact'                              => ['nullable', 'array', 'max:255'],
            'community_impact.*.name'                       => ['required_with:community_impact', 'string', 'max:255'],
            'community_impact.*.type'                       => ['required_with:community_impact', 'string', Rule::in([MetricIndicatorType::CommunityImpact])],

            'inclusion_equity'                              => ['nullable', 'array', 'max:255'],
            'inclusion_equity.*.name'                       => ['required_with:inclusion_equity', 'string', 'max:255'],
            'inclusion_equity.*.type'                       => ['required_with:inclusion_equity', 'string', Rule::in([MetricIndicatorType::InclusionEquity])],

            'project_sustainability'                        => ['nullable', 'array', 'max:255'],
            'project_sustainability.*.name'                 => ['required_with:project_sustainability', 'string', 'max:255'],
            'project_sustainability.*.type'                 => ['required_with:project_sustainability', 'string', Rule::in([MetricIndicatorType::ProjectSustainability])],
            // perception
            'linking_satisfaction'                          => ['nullable', 'array', 'max:255'],
            'linking_satisfaction.*.name'                   => ['required_with:linking_satisfaction', 'string', 'max:255'],
            'linking_satisfaction.*.type'                   => ['required_with:linking_satisfaction', 'string', Rule::in([MetricIndicatorType::LinkingSatisfaction])],

            'collaboration_continuity'                      => ['nullable', 'array', 'max:255'],
            'collaboration_continuity.*.name'               => ['required_with:collaboration_continuity', 'string', 'max:255'],
            'collaboration_continuity.*.type'               => ['required_with:collaboration_continuity', 'string', Rule::in([MetricIndicatorType::CollaborationContinuity])],

            'communication_management'                      => ['nullable', 'array', 'max:255'],
            'communication_management.*.name'               => ['required_with:communication_management', 'string', 'max:255'],
            'communication_management.*.type'               => ['required_with:communication_management', 'string', Rule::in([MetricIndicatorType::CommunicationManagement])],
            // institutional
            'infrastructure_strengthening'                  => ['nullable', 'array', 'max:255'],
            'infrastructure_strengthening.*.name'           => ['required_with:infrastructure_strengthening', 'string', 'max:255'],
            'infrastructure_strengthening.*.type'           => ['required_with:infrastructure_strengthening', 'string', Rule::in([MetricIndicatorType::InfrastructureStrengthening])],
            'network_participation'                         => ['nullable', 'array', 'max:255'],
            'network_participation.*.name'                  => ['required_with:network_participation', 'string', 'max:255'],
            'network_participation.*.type'                  => ['required_with:network_participation', 'string', Rule::in([MetricIndicatorType::NetworkParticipation])],
            'intersectoral_linkage_maturity'                => ['nullable', 'array', 'max:255'],
            'intersectoral_linkage_maturity.*.name'         => ['required_with:intersectoral_linkage_maturity', 'string', 'max:255'],
            'intersectoral_linkage_maturity.*.type'         => ['required_with:intersectoral_linkage_maturity', 'string', Rule::in([MetricIndicatorType::IntersectoralLinkageMaturity])],
            // public innovation
            'public_services'                               => ['nullable', 'array', 'max:255'],
            'public_services.*.name'                        => ['required_with:public_services', 'string', 'max:255'],
            'public_services.*.type'                        => ['required_with:public_services', 'string', Rule::in([MetricIndicatorType::PublicServices])],
            'data_transparency'                             => ['nullable', 'array', 'max:255'],
            'data_transparency.*.name'                      => ['required_with:data_transparency', 'string', 'max:255'],
            'data_transparency.*.type'                      => ['required_with:data_transparency', 'string', Rule::in([MetricIndicatorType::DataTransparency])],
            'regional_replicability'                        => ['nullable', 'array', 'max:255'],
            'regional_replicability.*.name'                 => ['required_with:regional_replicability', 'string', 'max:255'],
            'regional_replicability.*.type'                 => ['required_with:regional_replicability', 'string', Rule::in([MetricIndicatorType::RegionalReplicability])],
            'digitalization_and_simplification'             => ['nullable', 'array', 'max:255'],
            'digitalization_and_simplification.*.name'      => ['required_with:digitalization_and_simplification', 'string', 'max:255'],
            'digitalization_and_simplification.*.type'      => ['required_with:digitalization_and_simplification', 'string', Rule::in([MetricIndicatorType::DigitalizationAndSimplification])],
        ];
    }

    protected function metricIndicatorAttributes(): array
    {
        return [
            'joint_publications'                            => 'publicaciones conjuntas',
            'patents'                                       => 'patentes solicitadas/otorgadas',
            'prototypes'                                    => 'prototipos',
            'registered_software'                           => 'software o modelos registrados',
            'technological_transfer_indicators'             => 'transferencias tecnológicas',
            'knowledge_training'                            => 'transferencias de conocimiento',
            'economic_estimates'                            => 'valor económico estimado',
            'direct_jobs_generated'                         => 'valor económico estimado',
            'indirect_jobs_generated'                       => 'valor económico estimado',
            'productivity_increases'                        => 'valor económico estimado',
            'products'                                      => 'productos',
            'services'                                      => 'servicios',
            'territorial_regional'                          => 'impacto territorial y regional',
            'direct_beneficiaries'                          => 'beneficiarios directos',
            'indirect_beneficiaries'                        => 'beneficiarios indirectos',
            'carbon_emissions'                              => 'emisiones de carbono',
            'community_impact'                              => 'impacto comunitario',
            'inclusion_equity'                              => 'equidad de inclusión',
            'project_sustainability'                        => 'sostenibilidad del proyecto',
            'linking_satisfaction'                          => 'satisfacción de enlace',
            'collaboration_continuity'                      => 'continuidad de colaboración',
            'communication_management'                      => 'gestión de comunicación',
            'infrastructure_strengthening'                  => 'fortalecimiento de infraestructura',
            'network_participation'                         => 'participación en red',
            'intersectoral_linkage_maturity'                => 'maturidad de enlace intersectoral',
            'digitalization_and_simplification'             => 'digitalización y simplificación',
        ];
    }
}
