import {
    mdiAccount,
    mdiDomain,
    mdiSchool,
    mdiFileCertificate,
    mdiAccountGroup,
    mdiCityVariant,
    mdiGraph,
    mdiCubeOutline,
    mdiCertificate,
} from "@mdi/js";

import { verifyPermission } from "@/Hooks/usePermissions";

export const profileConfigurations = {
    company: {
        label: "Perfil",
        route: "company.profile.edit",
        icon: mdiAccount,
        permission: "company.profile",
    },
    academic: {
        label: "Perfil",
        icon: mdiAccount,
        permission: "academic.profile",
        menu: [
            {
                label: "Información general",
                route: "academic.profile.edit",
                icon: mdiAccount,
                permission: "academic.profile",
            },
            {
                label: "Formación Académica",
                route: "academics.academicBackgrounds.index",
                icon: mdiSchool,
                permission: "academics.academicBackgrounds.index",
            },
            {
                label: "Certificaciones",
                route: "academics.certifications.index",
                icon: mdiFileCertificate,
                permission: "academics.certifications.index",
            },
        ],
    },
    institution: {
        label: "Perfil",
        icon: mdiAccount,
        permission: "institution.profile",
        menu: [
            {
                label: "Datos generales",
                route: "institution.profile.edit",
                icon: mdiCityVariant,
                permission: "institution.profile",
            },
            {
                label: "Estructura Organizacional",
                route: "institutions.departments.index",
                icon: mdiGraph,
                permission: "institutions.departments.index",
            },
            {
                label: "Personal Académico",
                route: "institutions.academics.index",
                icon: mdiAccountGroup,
                permission: "institutions.academics.index",
            },
            {
                label: "Instalaciones especializadas",
                route: "institutions.facilities.index",
                icon: mdiDomain,
                permission: "institutions.facilities.index",
            },
            {
                label: "Infraestructura Tecnológica",
                route: "institutions.equipments.index",
                icon: mdiCubeOutline,
                permission: "institutions.equipments.index",
            },
            {
                label: "Certificaciones",
                route: "institutions.certifications.index",
                icon: mdiCertificate,
                permission: "institutions.certifications.index",
            },
        ],
    },
    government: {
        label: "Perfil",
        route: "governmentAgency.profile.edit",
        icon: mdiAccount,
        permission: "governmentAgency.profile",
    },
    nonProfitOrganization: {
        label: "Perfil",
        route: "nonProfitOrganization.profile.edit",
        icon: mdiAccount,
        permission: "nonProfitOrganization.profile",
    },
};

export const getProfileConfig = () => {
    if (verifyPermission("company.profile")) {
        return profileConfigurations.company;
    }

    if (verifyPermission("academic.profile")) {
        return profileConfigurations.academic;
    }

    if (verifyPermission("institution.profile")) {
        return profileConfigurations.institution;
    }

    if (verifyPermission("governmentAgency.profile")) {
        return profileConfigurations.government;
    }

    if (verifyPermission("nonProfitOrganization.profile")) {
        return profileConfigurations.nonProfitOrganization;
    }
    return null;
};