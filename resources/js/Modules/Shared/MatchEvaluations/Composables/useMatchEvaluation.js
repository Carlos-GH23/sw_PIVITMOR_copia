import { router, useForm } from "@inertiajs/vue3";
import { computed, provide } from "vue";
import { error422 } from "@/Hooks/useErrorsForm";

export const useMatchEvaluation = (props) => {
    const { matchEvaluation } = props;

    const form = useForm({
        id: matchEvaluation?.data.id,
        title: matchEvaluation?.data.title,
        description: matchEvaluation?.data.description,
        start_date: matchEvaluation?.data.start_date,
        end_date: matchEvaluation?.data.end_date,
        story: matchEvaluation?.data.story,
        results: matchEvaluation?.data.results,
        goals: matchEvaluation?.data.goals,
        lessons: matchEvaluation?.data.lessons,
        categories: matchEvaluation?.data.categories?.map(category => category.id) ?? [],
        is_shared: matchEvaluation?.data.is_shared ?? false,

        match_evaluation_status_id: matchEvaluation?.data.match_evaluation_status_id ?? 1,

        //
        training_hours: matchEvaluation?.data.training_hours ?? null,
        economic_estimate: matchEvaluation?.data.economic_estimate ?? null,
        productivity_increase: matchEvaluation?.data.productivity_increase ?? null,
        emissions_percentage: matchEvaluation?.data.emissions_percentage ?? null,
        emissions_methodology: matchEvaluation?.data.emissions_methodology ?? null,
        community_impact_level: matchEvaluation?.data.community_impact_level ?? null,
        inclusion_equity_level: matchEvaluation?.data.inclusion_equity_level ?? null,
        project_sustainability_status: matchEvaluation?.data.project_sustainability_status ?? null,
        rating: matchEvaluation?.data.rating ?? 1,
        territorial_level: matchEvaluation?.data.territorial_level ?? null,
        continuity_percentage: matchEvaluation?.data.continuity_percentage ?? null,
        continuity_type: matchEvaluation?.data.continuity_type ?? null,
        communication_management_percentage: matchEvaluation?.data.communication_management_percentage ?? null,
        estimated_investment: matchEvaluation?.data.estimated_investment ?? null,
        infrastructure_level: matchEvaluation?.data.infrastructure_level ?? null,
        structure_type: matchEvaluation?.data.structure_type ?? null,
        maturity_level: matchEvaluation?.data.maturity_level ?? 1,
        public_service_percentage: matchEvaluation?.data.public_service_percentage ?? null,
        transparency_level: matchEvaluation?.data.transparency_level ?? null,
        process_digitalization_percentage: matchEvaluation?.data.process_digitalization_percentage ?? null,
        process_simplification_percentage: matchEvaluation?.data.process_simplification_percentage ?? null,
        interoperability_level: matchEvaluation?.data.interoperability_level ?? null,
        technology_level_transitions: matchEvaluation?.data.technology_level_transitions ?? [],
        participations: matchEvaluation?.data.participations ?? [],
        testimonials: matchEvaluation?.data.testimonials ?? [],
        partnership_agreements: matchEvaluation?.data.partnership_agreements ?? [],
        recognitions: matchEvaluation?.data.recognitions ?? [],
        derived_policies: matchEvaluation?.data.derived_policies ?? [],
        academic_offerings: matchEvaluation?.data.academic_offerings ?? [],

        scientific_technological: matchEvaluation?.data?.scientific_technological ?? [],
        economic: matchEvaluation?.data?.economic ?? [],
        institutional: matchEvaluation?.data?.institutional ?? [],
        social_environmental: matchEvaluation?.data?.social_environmental ?? [],
        perception_satisfaction: matchEvaluation?.data?.perception_satisfaction ?? [],
        public_innovation: matchEvaluation?.data?.public_innovation ?? [],
        technological_transfer_metrics: matchEvaluation?.data?.technological_transfer_metrics ?? [],
        audiences: matchEvaluation?.data?.audiences ?? [],
        sustainable_development_goals: matchEvaluation?.data?.sustainable_development_goals ?? [],

        joint_publications: matchEvaluation?.data?.joint_publications ?? [],
        patents: matchEvaluation?.data?.patents ?? [],
        prototypes: matchEvaluation?.data?.prototypes ?? [],
        registered_software: matchEvaluation?.data?.registered_software ?? [],
        technological_transfer_indicators: matchEvaluation?.data?.technological_transfer_indicators ?? [],
        knowledge_training: matchEvaluation?.data?.knowledge_training ?? [],
        economic_estimates: matchEvaluation?.data?.economic_estimates ?? [],
        direct_jobs_generated: matchEvaluation?.data?.direct_jobs_generated ?? [],
        indirect_jobs_generated: matchEvaluation?.data?.indirect_jobs_generated ?? [],
        productivity_increases: matchEvaluation?.data?.productivity_increases ?? [],
        products: matchEvaluation?.data?.products ?? [],
        services: matchEvaluation?.data?.services ?? [],
        new_market_access: matchEvaluation?.data?.new_market_access ?? [],
        territorial_regional: matchEvaluation?.data?.territorial_regional ?? [],
        direct_beneficiaries: matchEvaluation?.data?.direct_beneficiaries ?? [],
        indirect_beneficiaries: matchEvaluation?.data?.indirect_beneficiaries ?? [],
        carbon_emissions: matchEvaluation?.data?.carbon_emissions ?? [],
        community_impact: matchEvaluation?.data?.community_impact ?? [],
        inclusion_equity: matchEvaluation?.data?.inclusion_equity ?? [],
        project_sustainability: matchEvaluation?.data?.project_sustainability ?? [],
        linking_satisfaction: matchEvaluation?.data?.linking_satisfaction ?? [],
        collaboration_continuity: matchEvaluation?.data?.collaboration_continuity ?? [],
        communication_management: matchEvaluation?.data?.communication_management ?? [],
        infrastructure_strengthening: matchEvaluation?.data?.infrastructure_strengthening ?? [],
        network_participation: matchEvaluation?.data?.network_participation ?? [],
        intersectoral_linkage_maturity: matchEvaluation?.data?.intersectoral_linkage_maturity ?? [],
        public_services: matchEvaluation?.data?.public_services ?? [],
        data_transparency: matchEvaluation?.data?.data_transparency ?? [],
        regional_replicability: matchEvaluation?.data?.regional_replicability ?? [],
        digitalization_and_simplification: matchEvaluation?.data?.digitalization_and_simplification ?? [],
    });

    const storeForm = (isDraft = true) => {
        if (!isDraft) form.match_evaluation_status_id = 2;
        form.post(route(`${props.routeName}store`, {
            routeBack: props.routeBack,
            capabilityRequirementMatch: props.capabilityRequirementMatch.data.id
        }), {
            preserveScroll: false,
            preserveState: true,
            onError: () => {
                form.reset('match_evaluation_status_id')
                error422()
            },
        });
    };

    const updateForm = (isDraft = true) => {
        if (!isDraft) form.match_evaluation_status_id = 2;
        form.patch(route(`${props.routeName}update`, {
            routeBack: props.routeBack,
            matchEvaluation: props.matchEvaluation.data.id
        }), {
            preserveScroll: false,
            preserveState: true,
            onError: () => {
                form.reset('match_evaluation_status_id')
                error422()
            },
        });
    };

    provide("matchEvaluationForm", form);

    return {
        processing: computed(() => form.processing),
        storeForm,
        updateForm,
    };
}

export const updateSuccessStory = async (matchEvaluation) => {
    router.patch(route("matchEvaluations.enableSuccessStory", matchEvaluation), {
        onSuccess: () => {
            resolve(true);
        },
        onError: () => {
            resolve(false);
        }
    });
}
