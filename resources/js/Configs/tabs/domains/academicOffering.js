import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/AcademicOfferings/TabInfo.vue"
            )
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/AcademicOfferings/TabClassification.vue"
            )
        ),
    },
    {
        value: "accreditations",
        name: "Acreditaciones",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/AcademicOfferings/TabResources.vue"
            )
        ),
    },
];
