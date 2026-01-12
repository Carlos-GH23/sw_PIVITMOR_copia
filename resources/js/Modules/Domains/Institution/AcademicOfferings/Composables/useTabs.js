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
            "name",
            "description",
            "objective",
            "graduate_profile",
            "website",
            "semester_cost",
            "duration_months",
            "revoe",
            "educational_level_id",
            "study_mode_id",
            "department_id",
            "keywords",
        ],
    },
    {
        value: "accreditations",
        icon: mdiNumeric2Circle,
        name: "Acreditaciones",
        fields: [
            "copaes_type",
            "copaes_expiry_date",
            "snp_start_date",
            "snp_end_date",
            "ciees_type",
            "ciees_level",
            "ciees_expiry_date",
            "fimpes_accreditation_id",
        ],
    },
    {
        value: "classification",
        icon: mdiNumeric3Circle,
        name: "Clasificación y categorización",
        fields: ["economic_sectors", "oecd_sectors"],
    },
    {
        value: "resources",
        icon: mdiNumeric4Circle,
        name: "Recursos asociados",
        fields: [
            "files", 
            "files.*.title", 
            "files.*.description"
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
        tabs,
        tabErrors,
        step: computed(() =>
            tabs.findIndex((tab) => tab.value === activeTab.value)
        ),
    };
};