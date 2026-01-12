import {
    mdiDrawingBox,
    mdiImageMultiple,
    mdiAccountBox,
    mdiPageLayoutHeader,
    mdiPageLayoutFooter,
    mdiFormatFont,
    mdiFormatColorFill,
    mdiChatQuestion,
    mdiDrawPen,
    mdiAccountWrench,
} from "@mdi/js";

export default [
    {
        label: "Contenidos",
        permission: "menu.catalog",
        icon: mdiDrawingBox,
        menu: [
            {
                label: "Preguntas frecuentes",
                icon: mdiChatQuestion,
                route: "faqs.index"
            },
            {
                label: "Información de contacto",
                icon: mdiAccountBox,
                route: "contactInformation.edit"
            },
        ],
    },
    {
        label: "Diseño del portal",
        permission: "menu.catalog",
        icon: mdiDrawPen,
        menu: [
            {
                label: "Encabezados",
                icon: mdiPageLayoutHeader,
                route: "welcome"
            },
            {
                label: "Pie de página",
                icon: mdiPageLayoutFooter,
                route: "welcome"
            },
            {
                label: "Fuentes",
                icon: mdiFormatFont,
                route: "welcome"
            },
            {
                label: "Colores",
                icon: mdiFormatColorFill,
                route: "welcome"
            },
            {
                label: "Imagenes",
                icon: mdiImageMultiple,
                route: "welcome"
            },
        ],
    },
]