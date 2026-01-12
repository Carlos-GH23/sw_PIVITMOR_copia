import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { economicSectors } from './useDictionaries';

export function useSmartSearch(props) {
    const isLoading = ref(false);

    const applyFilters = () => {
        isLoading.value = true;
        router.get(route('welcome.smartSearch'), props.filters, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            }
        });
    };

    const applySectorFilter = (sectorName) => {
        if (props.filters.social_sector === sectorName) {
            props.filters.social_sector = null;
        } else {
            props.filters.social_sector = sectorName;
        }
        applyFilters();
    };

    const onSearchInput = (event) => {
        if (event.target.value === '') {
            isLoading.value = true;
            router.get(route('welcome.smartSearch'), {
                page: 1,
                rows: 8
            }, {
                preserveScroll: false,
                preserveState: false,
                replace: true,
                onFinish: () => {
                    isLoading.value = false;
                }
            });
        }
    };

    const getSectorIcon = (sectorName) => {
        if (!sectorName) return '/icons/economic-sectors/Vivienda-habitat_rosa_iconos_pivitmor.svg';
        const sector = economicSectors.find(s => s.name === sectorName);
        return sector ? sector.src : '/icons/economic-sectors/Vivienda-habitat_rosa_iconos_pivitmor.svg';
    };

    return {
        isLoading,
        applyFilters,
        applySectorFilter,
        onSearchInput,
        getSectorIcon
    };
}
