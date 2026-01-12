import { defineAsyncComponent } from "vue";

export default [
    {
        value: "info",
        name: "Información",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Academics/TabInfo.vue")
        ),
    },
    {
        value: "disciplines",
        name: "Disciplinas",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Academics/TabDisciplines.vue")
        ),
    },
    {
        value: "recognitions",
        name: "Reconocimientos",
        component: defineAsyncComponent(() =>
            import("@/Components/Domains/Academics/TabRecognitions.vue")
        ),
    },
];
