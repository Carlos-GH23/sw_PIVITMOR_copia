import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { mdiNumeric1Circle, mdiNumeric2Circle, mdiNumeric3Circle, mdiNumeric4Circle } from '@mdi/js';

export const useRequirementTabs = () => {
    const activeTab = ref("info");
    const errors = computed(() => usePage().props.errors);

    const getErrorRoot = (errorKey) => errorKey.split('.')[0];

    const tabErrors = computed(() => {
        return tabs.reduce((acc, tab) => {
            if (!tab.fields?.length) {
                acc[tab.value] = false;
                return acc;
            }

            acc[tab.value] = Object.keys(errors.value || {}).some((errorKey) => {
                const root = getErrorRoot(errorKey);
                return tab.fields.includes(root);
            });

            return acc;
        }, {});
    });

    return {
        activeTab,
        tabErrors,
        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };
}

export const tabs = [
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información general",
        fields: [
            "title",
            "description",
            "start_date",
            "end_date",
        ]
    },
    {
        value: "story",
        icon: mdiNumeric2Circle,
        name: "Historia completa",
        fields: [
            "story",
            "results",
            "goals",
            "lessons",
        ]
    },
    {
        value: "metrics",
        icon: mdiNumeric3Circle,
        name: "Métricas de impacto",
        fields: [
            // scientific_metrics
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
            // economic_metrics
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
            // social
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
            // perception
            "perception_satisfaction",
            "rating",
            "linking_satisfaction",
            "testimonials",
            "continuity_percentage",
            "continuity_type",
            "collaboration_continuity",
            "communication_management_percentage",
            "communication_management",
            // institutional
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
            // innovation
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
    {
        value: "confirmation",
        icon: mdiNumeric4Circle,
        name: "Confirmación",
    },
];