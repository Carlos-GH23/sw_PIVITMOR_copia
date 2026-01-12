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
            "logo.file",
            "name",
            "legal_name",
            "rfc",
            "year",
            "mission",
            "vision",
            "overview",
            "keywords"
        ],
    },
    {
        value: "technology",
        icon: mdiNumeric2Circle,
        name: "EBT",
        fields: [
            "technology.origen_id",
            "technology.innovation_type_id",
            "technology.market_reach_id",
            "technology.technology_level_id",
            "technology.company_size_id",
            "technology.num_employees",
            "technology.description",
            "economic_sectors",
            "oecd_sectors",
            "files"
        ],
    },
    {
        value: "location",
        icon: mdiNumeric3Circle,
        name: "Dirección y mapa",
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
        name: "Contacto y redes sociales",
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
        value: "reniecyt",
        icon: mdiNumeric5Circle,
        name: "RENIECyT",
        fields: [
            "reniecyt.register_number",
            "reniecyt.start_date",
            "reniecyt.end_date"
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