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
            "technical_description",
            "start_date",
            "end_date",
            "keywords",
            "photos",
            "photos.*.title",
            "photos.*.description",
        ],
    },
    {
        value: "application",
        icon: mdiNumeric2Circle,
        name: "Valor y aplicaciones",
        fields: [
            "problem_statement",
            "potential_applications",
            "intellectual_property_id",
            "technology_level_id",
        ],
    },
    {
        value: "classifications",
        icon: mdiNumeric3Circle,
        name: "Clasificación y categorización",
        fields: [
            "activities",
            "knowledge_areas",
            "oecd_sectors",
            "economic_sectors",
        ],
    },
    {
        value: "resources",
        icon: mdiNumeric4Circle,
        name: "Recursos asociados",
        fields: [
            "files",
            "academics",
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
