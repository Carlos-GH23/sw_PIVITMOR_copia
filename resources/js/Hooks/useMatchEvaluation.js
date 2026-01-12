import { mdiCheck, mdiClose } from '@mdi/js'

export function useConfigEvaluation(routeName, relationship) {
    const routeBack = `${routeName}index`;

    const iconStatus = (match) => {
        const status = match?.[relationship]?.status;
        
        if (status) {
            return {
                path: mdiCheck,
                class: `bg-${status.color}-500 text-white rounded-full`,
                title: status.description,
            }
        }

        return {
            path: mdiClose,
            class: 'bg-gray-300 text-black rounded-full',
            title: 'Pendiente',
        }
    }

    const actionButtons = (match) => {
        const status = match?.[relationship]?.status;
        if (status) {
            return {
                disabled: (match.match_status_id === 3 && status.id === 1) ? false : true,
                route: route('matchEvaluations.edit', { routeBack: routeBack, matchEvaluation: match[relationship].id }),
            }
        }

        return {
            disabled: match.match_status_id === 3 ? false : true,
            route: route('matchEvaluations.create', { routeBack: routeBack, capabilityRequirementMatch: match.id }),
        }
    }

    return { iconStatus, actionButtons }
}