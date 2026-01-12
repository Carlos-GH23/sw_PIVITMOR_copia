import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/AcademicBodies/TabInfo.vue"
            )
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/AcademicBodies/TabClassification.vue"
            )
        ),
    },
    {
        value: "resources",
        name: "Recursos",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/AcademicBodies/TabResources.vue"
            )
        ),
    },
];
