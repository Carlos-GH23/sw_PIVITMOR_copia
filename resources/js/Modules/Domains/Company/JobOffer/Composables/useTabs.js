import { mdiNumeric1Circle, mdiNumeric2Circle, mdiNumeric3Circle, mdiNumeric4Circle } from "@mdi/js";
import { computed, ref } from "vue";
import { usePage } from '@inertiajs/vue3';

export const tabs = [
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información General",
        fields: [
            "name",
            "position",
            "gender",
            "job_offer_type_id",
            "academic_degree_id",
            "travel_requirements",
            "start_date",
            "end_date",
        ]
    },
    {
        value: "description",
        icon: mdiNumeric2Circle,
        name: "Descripción",
        fields: [
            "job_description",
            "responsibilities",
            "skills_languages",
            "observations",
            "comments",
        ]
    },
    {
        value: "classification",
        icon: mdiNumeric3Circle,
        name: "Clasificación",
        fields: [
            "oecd_sectors",
            "economic_sectors",
        ]
    },
    {
        value: "contact",
        icon: mdiNumeric4Circle,
        name: "Información de contacto",
        fields: [
            "contact.name",
            "contact.email",
            "contact.website",
            "phones",
            "phones.*.number",
            "phones.*.dial_code",
            "phones.*.type",
            "social_links",
            "social_links.*.url",
            "social_links.*.type",
        ]
    },
];

export const useTabs = () => {
    const activeTab = ref("info");
    const errors = computed(() => usePage().props.errors);

    const fieldMatchesError = (fieldPattern, errorKey) => {
        if (!fieldPattern.includes('*')) {
            return fieldPattern === errorKey;
        }
        const regexPattern = fieldPattern
            .replace(/\./g, '\\.')
            .replace(/\*/g, '\\d+');
        const regex = new RegExp(`^${regexPattern}$`);
        return regex.test(errorKey);
    };

    const tabErrors = computed(() => {
        return tabs.reduce((acc, tab) => {
            if (!tab.fields) {
                acc[tab.value] = false;
                return acc;
            }

            acc[tab.value] = tab.fields.some((field) => {
                if (errors.value[field]) {
                    return true;
                }

                if (field.includes('*')) {
                    return Object.keys(errors.value).some(errorKey => 
                        fieldMatchesError(field, errorKey)
                    );
                }

                return false;
            });

            return acc;
        }, {});
    });

    return {
        activeTab,
        tabs,
        tabErrors,
        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };
};
