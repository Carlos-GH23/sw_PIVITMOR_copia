import {
    mdiAccount,
    mdiSecurity,
    mdiDomain,
    mdiAccountGroup,
    mdiAccountMultiple,
    mdiAccountSchool,
    mdiOfficeBuilding,
    mdiBank,
    mdiChartAreaspline,
} from "@mdi/js";

export default [
    {
        label: "Gestión de reportes",
        permission: "reports",
        icon: mdiChartAreaspline,
        route: "reports.index",
        // menu: [
        //     {
        //         label: "Usuarios PIVITMor",
        //         icon: mdiAccountGroup,
        //         route: "welcome"
        //     },
        //     {
        //         label: "IES/CI",
        //         icon: mdiDomain,
        //         route: "welcome"
        //     },
        //     {
        //         label: "Académicos",
        //         icon: mdiAccountSchool,
        //         route: "welcome"
        //     },
        //     {
        //         label: "Empresas",
        //         icon: mdiOfficeBuilding,
        //         route: "welcome"
        //     },
        //     {
        //         label: "Dependencias de gobierno",
        //         icon: mdiBank,
        //         route: "welcome"
        //     },
        //     {
        //         label: "Profesionistas",
        //         icon: mdiAccountMultiple,
        //         route: "welcome"
        //     },
        //     {
        //         label: "ONG",
        //         icon: mdiAccount,
        //         route: "welcome"
        //     },
        // ],
    },
]