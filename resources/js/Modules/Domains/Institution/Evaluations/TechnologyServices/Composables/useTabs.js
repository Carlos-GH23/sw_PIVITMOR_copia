import { ref } from "vue";

export const useTabs = () => {
    const activeTab = ref("info");
    const tabs = [
        {
            value: "info",
            name: "Información general",
        },
        {
            value: "classifications",
            name: "Clasificación",
        },
        {
            value: "resources",
            name: "Recursos",
        },
    ];

    return {
        activeTab,
        tabs,
    }
}