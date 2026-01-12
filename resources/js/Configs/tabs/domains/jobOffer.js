import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Company/JobOffers/TabInfo.vue")
        ),
    },
    {
        value: "classification",
        name: "Clasificación",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/Company/JobOffers/TabClassification.vue"
            )
        ),
    },
    {
        value: "contact",
        name: "Contacto",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Company/JobOffers/TabContact.vue")
        ),
    },
];
