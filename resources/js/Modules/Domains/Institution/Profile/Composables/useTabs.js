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
        name: "Información General",
        fields: [
            "name",
            "institution_category_id",
            "institution_type_id",
            "description",
            "logo.file",
            "keywords",
        ],
    },
    {
        value: "address",
        icon: mdiNumeric2Circle,
        name: "Dirección",
        fields: [
            "location.state_id",
            "location.municipality_id",
            "location.neighborhood_id",
            "location.postal_code",
            "location.street",
            "location.exterior_number",
            "location.interior_number",
            "location.latitude",
            "location.longitude",
        ],
    },
    {
        value: "contact",
        icon: mdiNumeric3Circle,
        name: "Contacto",
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
        ],
    },
    {
        value: "register",
        icon: mdiNumeric4Circle,
        name: "RENIECyT",
        fields: [
            "reniecyt.register_number",
            "reniecyt.start_date",
            "reniecyt.end_date"],
    },
    {
        value: "clasification",
        icon: mdiNumeric5Circle,
        name: "Clasificación",
        fields: [
            "oecd_sectors",
            "knowledge_areas",
            "economic_sectors"],
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