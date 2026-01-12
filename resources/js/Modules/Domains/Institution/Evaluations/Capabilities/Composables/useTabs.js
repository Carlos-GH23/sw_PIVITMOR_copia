export const useTabs = () => {
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
        tabs,
    }
}