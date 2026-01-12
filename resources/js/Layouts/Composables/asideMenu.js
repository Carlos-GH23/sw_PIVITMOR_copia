import {
    mdiAccount,
    mdiInformation,
    mdiMonitorDashboard,
} from "@mdi/js";
import { getProfileConfig } from "./profileMenu";
import { computed } from "vue";
import catalogMenu from "./Menus/catalogMenu";
import securityMenu from "./Menus/securityMenu";
import contendAndDesignMenu from "./Menus/contendAndDesignMenu";
import reportMenu from "./Menus/reportMenu";
import adminMenu from "./Menus/adminMenu";
import institutionMenu from "./Menus/institutionMenu";
import companyMenu from "./Menus/companyMenu";
import userMenu from "./Menus/userMenu";

export const baseMenu = [
    {
        labelGroup: "Inicio",
        items: [
            {
                label: "Dashboard",
                route: "dashboard",
                icon: mdiMonitorDashboard,
            },
        ],
    },
    {
        labelGroup: "Administración",
        items: [
            ...securityMenu,
            ...userMenu,
            ...catalogMenu,
            ...contendAndDesignMenu,
            ...reportMenu,
            ...adminMenu,
            ...institutionMenu,
            ...companyMenu,
        ],
    },
];

export const useAside = () => {
    const asideMenu = computed(() => {
        const profileConfig = getProfileConfig();

        return baseMenu.map((section) => {
            if (section.labelGroup === "Inicio") {
                return {
                    ...section,
                    items: [
                        ...section.items,
                        profileConfig, // Agregar configuración dinámica
                    ].filter(Boolean), // Filtrar nulls
                };
            }
            return section;
        });
    });

    return {
        asideMenu,
    };
};