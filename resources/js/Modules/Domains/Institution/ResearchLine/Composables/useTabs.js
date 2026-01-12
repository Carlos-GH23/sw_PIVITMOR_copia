import { ref } from "vue";

export const useResearchLineTabs = () => {
    const activeTab = ref("research");

    return {
        activeTab,
    };
}