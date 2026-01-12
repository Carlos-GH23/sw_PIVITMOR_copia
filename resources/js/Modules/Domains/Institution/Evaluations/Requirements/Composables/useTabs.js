import { ref, computed } from "vue";
import { mdiNumeric1Circle, mdiNumeric2Circle, mdiNumeric3Circle, mdiNumeric4Circle } from '@mdi/js';

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
            value: "images",
            icon: mdiNumeric3Circle,
            name: "Imagenes",
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