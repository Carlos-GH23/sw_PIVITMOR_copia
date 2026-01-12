import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { mdiNumeric1Circle, mdiNumeric2Circle, mdiNumeric3Circle, mdiNumeric4Circle } from '@mdi/js';

export const useRequirementTabs = () => {
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
        tabErrors,
        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };
}

export const tabs = [
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información general",
        fields: [
            "photos",
            "photos.*.file",
            "photos.*.title",
            "photos.*.description",
            "title",
            "technical_description",
            "start_date",
            "end_date",
            "keywords",
        ]
    },
    {
        value: "application",
        icon: mdiNumeric2Circle,
        name: "Valor y aplicaciones",
        fields: [
            "need_statement",
            "potential_applications",
            "intellectual_property_id",
            "technology_level_id",
        ]
    },
    {
        value: "clasifications",
        icon: mdiNumeric3Circle,
        name: "Clasificación y categorización",
        fields: [
            "oecd_sectors",
            "economic_sectors",
        ]
    },
    {
        value: "confirmation",
        icon: mdiNumeric4Circle,
        name: "Confirmación",
    },
];

export const tabsInfo = () => {
    const activeTab = ref("info");
    const tabs = [
        {
            value: "info",
            icon: mdiNumeric1Circle,
            name: "Información general",
        },
        {
            value: "clasifications",
            icon: mdiNumeric2Circle,
            name: "Clasificación",
        },
        {
            value: "images",
            icon: mdiNumeric3Circle,
            name: "Imagenes",
        },
    ];

    return {
        tabs,
        activeTab,

        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };
}