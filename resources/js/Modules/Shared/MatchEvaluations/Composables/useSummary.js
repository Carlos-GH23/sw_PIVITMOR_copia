import { computed } from 'vue'

export function useSummary(form, props) {
    const { technologyLevels, impactMetrics, categories } = props

    const parentCategory = computed(() => {
        for (const parent of categories) {
            if (parent.children?.some(child => form.categories?.includes(child?.id))) {
                return parent.name;
            }
        }

        return 'Sin categoría';
    });

    const firstTechnologyTransition = computed(() => {
        const transitions = form.technology_level_transitions?.[0];
        if (!transitions) return null;

        return {
            initial: technologyLevels.find(level => level.id === transitions.initial_id),
            final: technologyLevels.find(level => level.id === transitions.final_id),
        };
    });

    const allTechnologyTransitions = computed(() => {
        const transitions = form.technology_level_transitions;
        if (!transitions) return null;

        return transitions.map(transition => ({
            initial: technologyLevels.find(level => level.id === transition.initial_id) || null,
            final: technologyLevels.find(level => level.id === transition.final_id) || null,
        }));
    });


    const technologicalTransferNames = computed(() => {
        return impactMetrics.technological_transfers
            ?.filter(m => form.technological_transfer_metrics.includes(m.id))
            .map(m => m.name)
            .join(', ');
    });

    const sustainableDevelopmentGoalNames = computed(() => {
        return form.sustainable_development_goals
            .map(id => impactMetrics.sustainable_development_goals.find(goal => goal.id === id)?.name)
            .filter(Boolean);
    });

    const metricIndicatorNames = (type) => {
        return form[type].map(item => item.name).join(', ')
    }

    return {
        metricIndicatorNames,
        //      
        parentCategory,
        firstTechnologyTransition,
        allTechnologyTransitions,
        technologicalTransferNames,
        sustainableDevelopmentGoalNames,
    };
}
