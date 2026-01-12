import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/Certifications/TabInfo.vue"
            )
        ),
    },
    {
        value: "resources",
        name: "Recursos",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/Certifications/TabResources.vue"
            )
        ),
    },
];
