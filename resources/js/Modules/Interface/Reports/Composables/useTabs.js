import { ref } from "vue";

export const useTabs = () => {
    const activeTab = ref("system");

    const tabs = [
        {
            value: "system",
            name: "Uso del sistema",
        },
        {
            value: "capabilitiesRequirements",
            name: "Capacidades y necesidades",
        },
        {
            value: "techServices",
            name: "Servicios tecnológicos",
        },
        {
            value: "matchings",
            name: "Vinculaciones",
        },
        {
            value: "institutions",
            name: "Desempeño institucional",
        },
        {
            value: "snii",
            name: "SNII",
        }
    ];

    return {
        activeTab,
        tabs,
    };
};
