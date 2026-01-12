import {
    mdiFlask,
    mdiFinance,
    mdiEarth,
    mdiEmoticonHappyOutline,
    mdiOfficeBuilding,
    mdiCityVariantOutline,
} from "@mdi/js";
import { computed, defineAsyncComponent } from "vue";
import { usePage } from "@inertiajs/vue3";

export const useAccordion = (allowed) => {
    const errors = computed(() => usePage().props.errors || {})
    const getErrorRoot = (errorKey) => errorKey.split('.')[0]

    const baseItems = [
        {
            value: "scientific_metrics",
            icon: mdiFlask,
            title: "Impacto Científico-tecnológica",
            isDisabled: !allowed.scientific_technological,
            component: defineAsyncComponent(() =>
                import('../Components/ScientificMetrics.vue')
            ),
            fields: [
                "scientific_technological",
                "joint_publications",
                "patents",
                "prototypes",
                "registered_software",
                "technology_level_transitions",
                "technological_transfer_indicators",
                "technological_transfer_metrics",
                "participations",
                "audiences",
                "knowledge_training",
                "training_hours",
            ]
        },
        {
            value: "economic_metrics",
            icon: mdiFinance,
            title: "Impacto económico",
            isDisabled: !allowed.economic,
            component: defineAsyncComponent(() =>
                import('../Components/EconomicMetrics.vue')
            ),
            fields: [
                "economic",
                "economic_estimate",
                "economic_estimates",
                "direct_jobs_generated",
                "indirect_jobs_generated",
                "productivity_increase",
                "productivity_increases",
                "products",
                "services",
                "territorial_level",
                "territorial_regional",
            ]
        },
        {
            value: "social_environmental_metrics",
            icon: mdiEarth,
            title: "Impacto social y ambiental",
            isDisabled: !allowed.social_environmental,
            component: defineAsyncComponent(() =>
                import('../Components/SocialEnvironmentalMetrics.vue')
            ),
            fields: [
                "social_environmental",
                "direct_beneficiaries",
                "indirect_beneficiaries",
                "emissions_percentage",
                "emissions_methodology",
                "carbon_emissions",
                "community_impact_level",
                "community_impact",
                "sustainable_development_goals",
                "inclusion_equity_level",
                "inclusion_equity",
                "project_sustainability_status",
                "project_sustainability",
            ]
        },
        {
            value: "perception_metrics",
            icon: mdiEmoticonHappyOutline,
            title: "Percepción y satisfacción",
            isDisabled: !allowed.perception_satisfaction,
            component: defineAsyncComponent(() =>
                import('../Components/PerceptionMetrics.vue')
            ),
            fields: [
                "perception_satisfaction",
                "rating",
                "linking_satisfaction",
                "testimonials",
                "continuity_percentage",
                "continuity_type",
                "collaboration_continuity",
                "communication_management_percentage",
                "communication_management",
            ]
        },
        {
            value: "institution_metrics",
            icon: mdiOfficeBuilding,
            title: "Impacto institucional",
            isDisabled: !allowed.institutional,
            component: defineAsyncComponent(() =>
                import('../Components/InstitutionalMetrics.vue')
            ),
            fields: [
                "institutional",
                "partnership_agreements",
                "infrastructure_level",
                "estimated_investment",
                "infrastructure_strengthening",
                "academic_offerings",
                "network_participation",
                "recognitions",
                "maturity_level",
                "structure_type",
                "intersectoral_linkage_maturity",
            ]
        },
        {
            value: "innovation_metrics",
            icon: mdiCityVariantOutline,
            title: "Gobierno e innovación pública",
            isDisabled: !allowed.public_innovation,
            component: defineAsyncComponent(() =>
                import('../Components/InnovationMetrics.vue')
            ),
            fields: [
                "public_innovation",
                "public_service_percentage",
                "public_services",
                "process_digitalization_percentage",
                "process_simplification_percentage",
                "interoperability_level",
                "digitalization_and_simplification",
                "transparency_level",
                "data_transparency",
                "regional_replicability",
                "derived_policies",
            ]
        },
    ]

    const items = computed(() => {
        return baseItems.map((item) => {
            const errorKeys = Object.keys(errors.value).filter((errorKey) => {
                const root = getErrorRoot(errorKey)
                return item.fields?.includes(root)
            })

            return {
                ...item,
                hasError: errorKeys.length > 0,
            }
        })
    })

    return items
}