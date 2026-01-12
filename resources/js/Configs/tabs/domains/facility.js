import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Institution/Facilities/TabInfo.vue")
        ),
    },
    {
        value: "resources",
        name: "Recursos",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/Facilities/TabResources.vue"
            )
        ),
    },
];
