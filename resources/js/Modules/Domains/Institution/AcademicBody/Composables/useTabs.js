import { ref } from "vue";

export const useAcademicGroupTabs = () => {
    const activeTab = ref("academic");

    return {
        activeTab,
    };
}