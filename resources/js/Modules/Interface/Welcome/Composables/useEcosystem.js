import { computed } from 'vue';
import { ICONS } from "@/Utils/Icons";

export const useEcosystem = (ecosystemStats) => {
    const ecosystemSectors = computed(() => [
        {
            category: "Instituciones de Educación Superior",
            amount: ecosystemStats.value.ies,
            icon: ICONS.ies.src,
        },
        {
            category: "Centros de Investigación",
            amount: ecosystemStats.value.ci,
            icon: ICONS.ci.src,
        },
        {
            category: "Industria/empresas",
            amount: ecosystemStats.value.companies,
            icon: ICONS.industry.src,
        },
        {
            category: "Investigadores/Académicos",
            amount: ecosystemStats.value.academics,
            icon: ICONS.academic.src,
        },
        {
            category: "Empresas de base tecnológica",
            amount: ecosystemStats.value.tech_companies,
            icon: ICONS.techCompany.src,
        },
        {
            category: "Necesidades tecnológicas activas",
            amount: ecosystemStats.value.requirements,
            icon: ICONS.techDemand.src,
        },
        {
            category: "Ofertas tecnológicas activas",
            amount: ecosystemStats.value.capabilities,
            icon: ICONS.techOffer.src,
        },
        {
            category: "Servicios tecnológicos",
            amount: ecosystemStats.value.technology_services,
            icon: ICONS.techServices.src,
        },
        {
            category: "Proyectos en colaboración",
            amount: ecosystemStats.value.collaborations,
            icon: ICONS.techCollaboration.src,
        }
    ]);

    return {
        ecosystemSectors
    };
};