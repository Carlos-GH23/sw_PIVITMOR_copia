import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información personal",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Capabilities/InfoTab.vue")
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Capabilities/ClassificationTab.vue")
        ),
    },
    {
        value: "resources",
        name: "Recursos",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Capabilities/ResourcesTab.vue")
        ),
    },
];
