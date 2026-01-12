import { mdiNumeric1Circle, mdiNumeric2Circle, mdiNumeric3Circle, mdiNumeric4Circle } from "@mdi/js";
import { computed, ref } from "vue";

export const useRequirementTabs = () => {
    const activeTab = ref("info");
    const tabs = [
        {
            value: "info",
            icon: mdiNumeric1Circle,
            name: "Información general",
        },
        {
            value: "clasifications",
            icon: mdiNumeric2Circle,
            name: "Clasificación",
        },
        {
            value: "resources",
            icon: mdiNumeric3Circle,
            name: "Recursos",
        },
        {
            value: "institution",
            icon: mdiNumeric4Circle,
            name: "Institución",
        },
    ];

    return {
        tabs,
        activeTab,

        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };
}