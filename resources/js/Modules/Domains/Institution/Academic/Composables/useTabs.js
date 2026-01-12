import {
    mdiNumeric1Circle,
    mdiNumeric2Circle,
    mdiNumeric3Circle,
    mdiNumeric4Circle,
} from "@mdi/js";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

export const tabs = [
    {
        value: "general",
        icon: mdiNumeric1Circle,
        name: "Información General",
        fields: ["photo.file", "first_name", "last_name", "second_last_name", "academic_position_id", "contact.email", "biography", "knowledge_lines", "academic_degree_id", "department_id", "gender"],
    },
    {
        value: "research",
        icon: mdiNumeric2Circle,
        name: "SNII",
        fields: ["sni.start_date", "sni.end_date", "sni.research_area_id", "sni.sni_level_id"],
    },
    {
        value: "profile",
        icon: mdiNumeric3Circle,
        name: "Perfil deseable",
        fields: ["profile.has_profile", "profile.start_date", "profile.end_date"],
    },
    {
        value: "classification",
        icon: mdiNumeric4Circle,
        name: "Clasificación",
        fields: ["oecd_sectors", "economic_sectors"],
    },
];

export const useTabs = () => {
    const activeTab = ref(tabs[0].value);
    const errors = computed(() => usePage().props.errors);

    const fieldMatchesError = (fieldPattern, errorKey) => {
        if (!fieldPattern.includes('*')) {
            return fieldPattern === errorKey;
        }
        const regexPattern = fieldPattern.replace(/\./g, '\\.').replace(/\*/g, '\\d+');
        const regex = new RegExp(`^${regexPattern}$`);
        return regex.test(errorKey);
    };

    const tabErrors = computed(() => {
        return tabs.reduce((acc, tab) => {
            if (!tab.fields) {
                acc[tab.value] = false;
                return acc;
            }
            acc[tab.value] = tab.fields.some((field) =>
                Object.keys(errors.value).some(errorKey => fieldMatchesError(field, errorKey))
            );
            return acc;
        }, {});
    });

    return {
        activeTab,
        tabErrors,
        step: computed(() => tabs.findIndex((tab) => tab.value === activeTab.value)),
    };
};