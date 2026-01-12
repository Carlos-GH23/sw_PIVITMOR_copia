import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información personal",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/TechnologyServices/TabInfo.vue")
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/TechnologyServices/TabClassification.vue"
            )
        ),
    },
    {
        value: "images",
        name: "Recursos",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/TechnologyServices/TabResources.vue")
        ),
    },
];
