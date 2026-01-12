import { router } from "@inertiajs/vue3";
import { useLoading } from "@/Hooks/useLoading";
import { hasActiveFilters } from "@/Helpers/filter";
import { computed, reactive } from "vue";

const excludeFields = ["page", "sort_by"];

export const useFilters = (filtersOn, routeName) => {
    const { isLoading, setLoading } = useLoading();
    const filters = reactive({});

    Object.keys(filtersOn).forEach((key) => {
        filters[key] = filtersOn[key];
    });

    const applyFilters = (preserveState) => {
        setLoading(true);
        router.get(route(`${routeName}`), filters, {
            preserveScroll: true,
            preserveState: preserveState,
            replace: true,
            onFinish: () => {
                setLoading(false);
            },
        });
    };

    const clearFilters = () => {
        setLoading(true);
        router.get(route(`${routeName}`), {
            replace: true,
            onFinish: () => {
                setLoading(false);
            },
        });
    };

    return {
        //
        filters,
        isLoading,
        // methods
        applyFilters,
        clearFilters,
        hasActiveSearch: hasActiveFilters(filters, excludeFields),
    };
};
