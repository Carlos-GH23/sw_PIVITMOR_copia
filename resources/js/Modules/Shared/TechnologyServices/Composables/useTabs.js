import {
    mdiNumeric1Circle,
    mdiNumeric2Circle,
    mdiNumeric3Circle,
    mdiNumeric4Circle,
} from "@mdi/js";
import { computed, ref } from "vue";
import { usePage } from '@inertiajs/vue3';

export const tabs = [
    
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información general",
        fields: [
            "title",
            "technical_description",
            "technology_service_type_id",
            "technology_service_category_id",
            "start_date",
            "end_date",
            "keywords",
            "photos",
            "photos.*.title",
            "photos.*.description",
        ]
    },
    {
        value: "classifications",
        icon: mdiNumeric2Circle,
        name: "Clasificación y categorización",
        fields: [
            "oecd_sectors",
            "economic_sectors",
        ]
    },
    {
        value: "resources",
        icon: mdiNumeric3Circle,
        name: "Recursos asociados",
        fields: [
            "department_id",
            "academics",
            "infrastructure",
            "technological_resources",
            "files",
            "files.*.title",
            "files.*.description",
        ]
    },
    {
        value: "confirmation",
        icon: mdiNumeric4Circle,
        name: "Confirmación",
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
        tabErrors,
        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };

};

export const tabsInfo = () => {
    const activeTab = ref("info");
    const tabs = [
        {
            value: "info",
            icon: mdiNumeric1Circle,
            name: "Información general",
        },
        {
            value: "classifications",
            icon: mdiNumeric2Circle,
            name: "Clasificación",
        },
        {
            value: "resources",
            icon: mdiNumeric3Circle,
            name: "Recursos asociados",
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
