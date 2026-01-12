import { reactive, ref } from 'vue';
import { router } from '@inertiajs/vue3';

export const useFilters = (propsFilters, routeName) => {
    const filters = reactive({
        startDate: propsFilters?.startDate ?? null,
        endDate: propsFilters?.endDate ?? null,
        userType: propsFilters?.userType ?? null,
        oecdSector: propsFilters?.oecdSector ?? null,
        economicSector: propsFilters?.economicSector ?? null,
        category: propsFilters?.category ?? null,
        researchArea: propsFilters?.researchArea ?? null,
        sniLevel: propsFilters?.sniLevel ?? null,
        gender: propsFilters?.gender ?? null,
        municipality: propsFilters?.municipality ?? null,
    });

    const appliedFilters = ref(createSnapshot(filters));
    const filtersVersion = ref(0);

    function createSnapshot(source) {
        return {
            startDate: source.startDate,
            endDate: source.endDate,
            userType: source.userType,
            oecdSector: source.oecdSector,
            economicSector: source.economicSector,
            category: source.category,
            researchArea: source.researchArea,
            sniLevel: source.sniLevel,
            gender: source.gender,
            municipality: source.municipality,
        };
    }

    const clearFilters = () => {
        Object.keys(filters).forEach(key => {
            filters[key] = null;
        });
        applyFilters();
    };

    const applyFilters = () => {
        appliedFilters.value = createSnapshot(filters);
        filtersVersion.value++;

        const params = {};
        Object.entries(filters).forEach(([key, value]) => {
            if (value !== null && value !== '') {
                params[key] = value;
            }
        });

        router.get(route(`${routeName}index`), params, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    };

    return {
        filters,
        appliedFilters,
        filtersVersion,
        clearFilters,
        applyFilters,
    };
};
