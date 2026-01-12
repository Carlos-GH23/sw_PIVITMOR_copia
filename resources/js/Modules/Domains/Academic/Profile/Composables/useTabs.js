import {
    mdiNumeric1Circle,
    mdiNumeric2Circle,
    mdiNumeric3Circle,
    mdiNumeric4Circle,
    mdiNumeric5Circle,
    mdiNumeric6Circle,
} from "@mdi/js";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

export const tabs = [
    {
        value: "info",
        icon: mdiNumeric1Circle,
        name: "Información personal",
        fields: [
            "first_name",
            "last_name",
            "second_last_name",
            "biography",
            "gender",
            "photo.file"
        ],
    },
    {
        value: "recognition",
        icon: mdiNumeric2Circle,
        name: "Reconocimientos",
        fields: [
            "sni.number",
            "sni.level",
            "sni.research_area_id",
            "sni.start_date",
            "sni.end_date",
            "profile.has_profile",
            "profile.start_date",
            "profile.end_date",
        ],
    },
    {
        value: "address",
        icon: mdiNumeric3Circle,
        name: "Domicilio",
        fields: [
            "location.state_id",
            "location.municipality_id",
            "location.neighborhood_id",
            "location.postal_code",
            "location.street",
            "location.exterior_number",
            "location.interior_number"
        ],
    },
    {
        value: "contact",
        icon: mdiNumeric4Circle,
        name: "Información de contacto",
        fields: [
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
    {
        value: "institution",
        icon: mdiNumeric5Circle,
        name: "Información institucional",
        fields: [
            "knowledge_lines",
            "knowledge_lines.*"
        ],
    },
    {
        value: "classification",
        icon: mdiNumeric6Circle,
        name: "Disciplinas y sectores económicos",
        fields: [
            "oecd_sectors",
            "economic_sectors"
        ],
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
