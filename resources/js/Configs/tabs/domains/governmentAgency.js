import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información general",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/GovernmentAgency/Profile/TabInfo.vue")
        ),
    },
    {
        value: "contact",
        name: "Contacto",
        component: defineAsyncComponent(() =>
            import(
                "@/Components/Domains/GovernmentAgency/Profile/TabContact.vue"
            )
        ),
    },
];
