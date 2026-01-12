import { 
    mdiAccount,
    mdiSchoolOutline,
    mdiFactory,
    mdiTownHall,
    mdiHandshakeOutline,
    mdiDomain
} from "@mdi/js";

export default [
    {
        label: "Usuarios",
        permission: "menu.users",
        icon: mdiAccount,
        menu: [
            {
                label: "Instituciones",
                route: "users.institutionProfile.index",
                icon: mdiDomain,
                permission: "users.institutionProfile",
            },
            {
                label: "Académicos",
                route: "users.academicProfile.index",
                icon: mdiSchoolOutline,
                permission: "users.academicProfile",
            },
            {
                label: "Empresas",
                route: "users.companyProfile.index",
                icon: mdiFactory,
                permission: "users.companyProfile",
            },
            {
                label: "Dependencias de gobierno",
                route: "users.governmentAgencyProfile.index",
                icon: mdiTownHall,
                permission: "users.governmentAgencyProfile",
            },
            {
                label: "Organizaciones No Gubernamentales",
                route: "users.nonProfitOrganizationProfile.index",
                icon: mdiHandshakeOutline,
                permission: "users.nonProfitOrganizationProfile",
            },
        ],
    },
]