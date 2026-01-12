import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Institution/Profile/TabInfo.vue")
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Institution/Profile/TabClassification.vue"
            )
        ),
    },
    {
        value: "contact",
        name: "Contacto",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Institution/Profile/TabContact.vue")
        ),
    },
];
