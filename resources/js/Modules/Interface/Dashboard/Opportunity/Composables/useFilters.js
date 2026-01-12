import debounce from "lodash/debounce";
import { router } from "@inertiajs/vue3";
import { useLoading } from "@/Hooks/useLoading";
import { useModal } from "@/Hooks/useModal";
import { nextTick, onMounted, reactive, ref, watch } from "vue";
import { hasActiveFilters } from "@/Helpers/filter";
import { sleep } from "@/Helpers/sleep";
import { usePage } from "@inertiajs/vue3";

export const useFilters = (filtersOn, routeName) => {
    const user = usePage().props.auth.user.data;
    const STORAGE_KEY = `user_dashboard_opportunity_preferences_${user.id}`;

    const { isLoading, setLoading } = useLoading();
    const { open, isOpen, close } = useModal();
    const isRestoring = ref(false);
    const isClearing = ref(false);

    const filters = reactive({
        search: filtersOn.search,
        keywords: filtersOn.keywords ?? [],
        resource_types: filtersOn.resource_types ?? [],
        intellectual_property_ids: filtersOn.intellectual_property_ids ?? [],
        institution_codes: filtersOn.institution_codes ?? [],
    });

    const applyFilters = () => {
        setLoading(true);
        router.get(route(`${routeName}`), filters, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            onFinish: () => {
                setLoading(false);
            },
        });
    };

    const clearFilters = async () => {
        isClearing.value = true;
        filters.keywords = [];
        filters.resource_types = [];
        filters.intellectual_property_ids = [];
        filters.institution_codes = [];
        filters.search = null;
        applyFilters();

        await nextTick();
        isClearing.value = false;
    };

    const triggerSearch = debounce(() => {
        applyFilters();
    }, 500);

    onMounted(async () => {
        const urlIsDirty = hasActiveFilters(filtersOn, ["page"]);
        const savedFilters = localStorage.getItem(STORAGE_KEY);

        if (urlIsDirty) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(filtersOn));
        } else if (savedFilters) {
            isRestoring.value = true;
            Object.assign(filters, JSON.parse(savedFilters));

            router.get(route(`${routeName}`), filters, {
                replace: true,
                preserveScroll: true,
                preserveState: true,
                onFinish: async () => {
                    await sleep(0.5);
                    isRestoring.value = false;
                },
            });

            await nextTick();
        }
    });

    watch(
        () => filters.search,
        (newVal) => {
            if (isClearing.value || isRestoring.value) return;
            triggerSearch();
        }
    );

    watch(
        filters,
        (newVal) => {
            if (isRestoring.value) return;
            localStorage.setItem(STORAGE_KEY, JSON.stringify(newVal));
        },
        { deep: true }
    );

    return {
        // attributes
        filters,
        isLoading,
        isRestoring,
        // methods
        openFilters: open,
        closeFilters: close,
        isOpenFilters: isOpen,
        applyFilters,
        clearFilters,
        setLoading,
    };
};
