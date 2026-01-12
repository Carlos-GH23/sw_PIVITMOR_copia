import { ref, reactive, watch, onMounted, toValue } from 'vue';
import { useLoading } from '@/Hooks/useLoading';
import debounce from 'lodash/debounce';
import axios from 'axios';

export function useReportTableTab(props, routeName, tabKey, appliedFilters, filtersVersion) {
    const { isLoading, setLoading } = useLoading();

    const data = ref(null);
    const isLoaded = ref(false);
    const error = ref(null);

    const tableFilters = reactive({
        search: null,
        rows: 5,
        page: 1,
    });

    const fetchData = async () => {
        if (props.activeTab !== tabKey) return;

        setLoading(true);
        error.value = null;

        try {
            const params = {
                ...toValue(appliedFilters),
                ...tableFilters,
            };
            const response = await axios.get(route(routeName), { params });
            data.value = response.data?.data ?? response.data;
            isLoaded.value = true;
        } catch (err) {
            console.warn(err);
            error.value = err;
        } finally {
            setLoading(false);
        }
    };

    const debouncedFetch = debounce(fetchData, 400);

    const onFiltersChange = (newFilters) => {
        const searchChanged = 'search' in newFilters && newFilters.search !== tableFilters.search;
        Object.assign(tableFilters, newFilters);
        searchChanged ? debouncedFetch() : fetchData();
    };

    const onClearFilters = () => {
        Object.assign(tableFilters, { search: null, rows: 5, page: 1 });
        fetchData();
    };

    watch(() => props.activeTab, (newTab) => {
        if (newTab === tabKey && !isLoaded.value) fetchData();
    });

    watch(filtersVersion, () => {
        isLoaded.value = false;
        tableFilters.page = 1;
        if (props.activeTab === tabKey) fetchData();
    });

    onMounted(() => {
        if (props.activeTab === tabKey) fetchData();
    });

    return {
        data,
        isLoading,
        tableFilters,
        fetchData,
        onFiltersChange,
        onClearFilters,
    };
}