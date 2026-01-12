import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/NonProfitOrganization/Profile/TabInfo.vue"
            )
        ),
    },
    {
        value: "contact",
        name: "Contacto",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/NonProfitOrganization/Profile/TabContact.vue"
            )
        ),
    },
];
