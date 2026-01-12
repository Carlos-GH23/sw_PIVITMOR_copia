import {
    mdiNumeric1Circle,
    mdiNumeric2Circle,
    mdiNumeric3Circle,
    mdiNumeric4Circle,
    mdiNumeric5Circle,
} from "@mdi/js";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

export const tabs = [
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información general",
        fields: [
            "title",
            "description",
            "speaker_bio",
            "keywords",
        ],
    },
    {
        value: "classifications",
        icon: mdiNumeric2Circle,
        name: "Clasificación y categorización",
        fields: [
            "oecd_sectors",
            "audience_types",
            "modality",
        ],
    },
    {
        value: "configuration",
        icon: mdiNumeric3Circle,
        name: "Programación",
        fields: [
            "start_date",
            "end_date",
            "start_time",
            "end_time",
            "department_id",
            "academics",
            "language",
        ],
    },
    {
        value: "technical_resources",
        icon: mdiNumeric4Circle,
        name: "Recursos técnicos",
        fields: [
            "technical_requirements",
            "files",
            "files.*.title",
            "files.*.description",
        ],
    },
    {
        value: "confirmation",
        icon: mdiNumeric5Circle,
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
            name: "Clasificación y categorización",
        },  
        {
            value: "configuration",
            icon: mdiNumeric3Circle,
            name: "Programación",
        },
        {
            value: "technical_resources",
            icon: mdiNumeric3Circle,
            name: "Recursos técnicos",
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
