import { mdiTagMultiple, mdiLayersSearch } from "@mdi/js";

export default [
    {
        label: "Oferta laboral",
        route: "jobOffers.index",
        icon: mdiTagMultiple,
        permission: "jobOffers.index",
    },
    {
        label: "Búsquedas",
        route: "searches",
        icon: mdiLayersSearch,
        // permission: "searches",
    },
]   