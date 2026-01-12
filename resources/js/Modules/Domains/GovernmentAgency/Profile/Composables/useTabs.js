import {
    mdiOfficeBuilding,
    mdiMapMarker,
    mdiPhone,
} from "@mdi/js";

import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

export const tabs = [
    {
        value: "info",
        icon: mdiOfficeBuilding,
        name: "Información General",
        fields: [
            "name",
            "acronym",
            "government_level_id",
            "economic_sector_id",
            "mission",
            "vision",
            "objectives",
            "keywords",
        ],
    },
    {
        value: "address",
        icon: mdiMapMarker,
        name: "Dirección",
        fields: [
            "location.state_id",
            "location.municipality_id",
            "location.colony_id",
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
        icon: mdiPhone,
        name: "Contacto",
        fields: [
            "contact.name",
            "contact.email",
            "contact.website",
            "phones",
            "social_links",
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