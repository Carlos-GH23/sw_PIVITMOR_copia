import {
    mdiApplicationCogOutline,
    mdiCog,
    mdiDatabase,
    mdiMagnify,
    mdiEmail,
    mdiBullhorn,
    mdiBookEducation,
    mdiTrophy
} from "@mdi/js";

export default [
    {
        label: "Solicitudes",
        route: "requests.index",
        icon: mdiBookEducation,
        permission: "requests",
    },
    {
        label: "Casos de Éxito",
        route: "matchEvaluations.index",
        icon: mdiTrophy,
        permission: "matchEvaluations.index",
    },
    {
        label: "Gestión de correos",
        route: "communication.index",
        icon: mdiEmail,
        permission: "communication.index",
    },
    {
        label: "Noticias",
        route: "notices.index",
        icon: mdiBullhorn,
        permission: "notices.index",
    },
    {
        label: "Ajustes",
        icon: mdiCog,
        permission: "menu.security",
        menu: [
            {
                label: "Respaldo de base de datos",
                route: "backup.settings.index",
                icon: mdiDatabase,
            },
            {
                label: "Sistema",
                route: "system.settings.index",
                icon: mdiApplicationCogOutline,
            },
        ]
    },
]