<?php

namespace App\Enums;

enum MetricIndicatorType: string
{
    case JointPublications = 'joint_publications';
    case Patents = 'patents';
    case Prototypes = 'prototypes';
    case RegisteredSoftware = 'registered_software';
    case TechnologicalTransfers = 'technological_transfer_indicators';
    case KnowledgeTraining = 'knowledge_training';
    case EconomicStimates = 'economic_estimates';
    case DirectJobsGenerated = 'direct_jobs_generated';
    case IndirectJobsGenerated = 'indirect_jobs_generated';
    case ProductivityIncreases = 'productivity_increases';
    case Products = 'products';
    case Services = 'services';
    case NewMarketAccess = 'new_market_access';
    case TerritorialRegional = 'territorial_regional';
    case DirectBeneficiaries = 'direct_beneficiaries';
    case IndirectBeneficiaries = 'indirect_beneficiaries';
    case CarbonEmissions = 'carbon_emissions';
    case CommunityImpact = 'community_impact';
    case InclusionEquity = 'inclusion_equity';
    case ProjectSustainability = 'project_sustainability';
    case LinkingSatisfaction = 'linking_satisfaction';
    case CollaborationContinuity = 'collaboration_continuity';
    case CommunicationManagement = 'communication_management';
    case InfrastructureStrengthening = 'infrastructure_strengthening';
    case NetworkParticipation = 'network_participation';
    case IntersectoralLinkageMaturity = 'intersectoral_linkage_maturity';
    case PublicServices = 'public_services';
    case DataTransparency = 'data_transparency';
    case RegionalReplicability = 'regional_replicability';
    case DigitalizationAndSimplification = 'digitalization_and_simplification';

    public function label(): string
    {
        return match ($this) {
            self::JointPublications => 'Publicaciones conjuntas',
            self::Patents => 'Patentes solicitadas/otorgadas',
            self::Prototypes => 'Prototipos',
            self::RegisteredSoftware => 'Software o modelos registrados',
            self::TechnologicalTransfers => 'Transferencias tecnológicas',
            self::KnowledgeTraining => 'Transferencia de conocimiento y capacitación',
            self::EconomicStimates => 'Valor económico estimado',
            self::DirectJobsGenerated => 'Empleos generados directos',
            self::IndirectJobsGenerated => 'Empleos generados indirectos',
            self::ProductivityIncreases => 'Incremento de productividad',
            self::Products => 'Productos',
            self::Services => 'Servicios',
            self::NewMarketAccess => 'Acceso a nuevos mercados',
            self::TerritorialRegional => 'Impacto territorial y regional',
            self::DirectBeneficiaries => 'Beneficiarios directos',
            self::IndirectBeneficiaries => 'Beneficiarios indirectos',
            self::CarbonEmissions => 'Emisiones de CO2',
            self::CommunityImpact => 'Impacto comunitario',
            self::InclusionEquity => 'Inclusión y equidad',
            self::ProjectSustainability => 'Sostenibilidad del proyecto',
            self::LinkingSatisfaction => 'Satisfacción vinculación',
            self::CollaborationContinuity => 'Continuidad de colaboración',
            self::CommunicationManagement => 'Comunicación y gestión',
            self::InfrastructureStrengthening => 'Fortalecimiento de infraestructura',
            self::NetworkParticipation => 'Participación en redes / clusters',
            self::IntersectoralLinkageMaturity => 'Nivel de madurez de la vinculación intersectorial',
            self::PublicServices => 'Mejora en servicios públicos',
            self::DataTransparency => 'Transparencia y datos abiertos',
            self::RegionalReplicability => 'Replicabilidad regional',
            self::DigitalizationAndSimplification => 'Digitalización y simplificación',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
