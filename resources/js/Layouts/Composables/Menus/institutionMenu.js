import {
    mdiAccountGroup,
    mdiAccountMultiple,
    mdiAccountWrench,
    mdiBookEducation,
    mdiFaceAgent,
    mdiHandCoin,
    mdiLayersSearchOutline,
    mdiLinkVariant,
    mdiShieldLock ,
    mdiOffer,
    mdiSchoolOutline
} from "@mdi/js";

export default [
    {
        label: "Oferta educativa",
        route: "academicOfferings.index",
        icon: mdiBookEducation,
        permission: "academicOfferings.index",
    },
    {
        label: "Grupos académicos",
        icon: mdiAccountGroup,
        permission: "academicBodies.index",
        menu: [
            {
                label: "Cuerpo académico",
                route: "academicBodies.index",
                icon: mdiSchoolOutline,
            },
            {
                label: "Lineas de investigación",
                route: "researchLines.index",
                icon: mdiLayersSearchOutline,
            },
        ],
    },
    {
        label: "Servicios tecnológicos",
        route: "technologyServices.index",
        icon: mdiAccountWrench,
        permission: "technologyServices.index",
    },
    {
        label: "Necesidades Tecnológicas",
        route: "requirements.index",
        icon: mdiHandCoin,
        permission: "requirements.index",
    },
    {
        label: "Capacidades Tecnológicas",
        route: "capabilities.index",
        icon: mdiOffer,
        permission: "capabilities.index",
    },
    {
        label: "Servicios de soporte",
        icon: mdiFaceAgent,
        permission: "menu.evaluation",
        menu: [
            {
                label: "Servicios tecnológicos",
                route: "technologyServices.evaluations.index",
                permission: "technologyServices.evaluations.index",
                icon: mdiAccountWrench,
            },
            {
                label: "Necesidades tecnológicas",
                route: "requirements.evaluations.index",
                permission: "requirements.evaluations.index",
                icon: mdiHandCoin,
            },
            {
                label: "Capacidades tecnológicas",
                route: "capabilities.evaluations.index",
                permission: "capabilities.evaluations.index",
                icon: mdiOffer,
            },
        ],
    },
    {
        label: "Conferencias",
        route: "conferences.index",
        icon: mdiAccountMultiple,
        permission: "conferences.index",
    },
    {
        label: "Vinculación",
        permission: "menu.match",
        icon: mdiLinkVariant,
        menu: [
            {
                label: "Necesidades",
                route: "requirements.matches.index",
                icon: mdiHandCoin,
                permission: "requirements.matches.index",
            },
            {
                label: "Capacidades",
                route: "capabilities.matches.index",
                icon: mdiOffer,
                permission: "capabilities.matches.index",
            },
        ],
    },
    {
        label: "Políticas de privacidad",
        route: "policies.index",
        icon: mdiShieldLock ,
        permission: "policies.index",
    },
]