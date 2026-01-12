import { mdiAccountBox, mdiLogout } from "@mdi/js";

export default [
    {
        group: "profile",
        items: [
            {
                routeName: "profile.edit",
                label: "Perfil",
                icon: mdiAccountBox,
                method: "get",
            },
        ],
    },
    {
        isSeparator: true,
    },
    {
        group: "session",
        items: [
            {
                label: "Cerrar sesión",
                icon: mdiLogout,
                routeName: "logout",
                method: "post",
            },
        ],
    },
];
