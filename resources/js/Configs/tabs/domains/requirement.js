import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información personal",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Requirements/TabInfo.vue")
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Requirements/TabClassification.vue")
        ),
    },
    {
        value: "images",
        name: "Recursos",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Requirements/TabImages.vue")
        ),
    },
];
