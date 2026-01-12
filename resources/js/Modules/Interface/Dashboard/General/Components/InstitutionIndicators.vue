<template>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-stretch">

        <div class="xl:col-span-1 h-full w-full flex">
            <HeroSection class="h-full w-full" :institution="institution" />
        </div>

        <div class="xl:col-span-2 h-full w-full flex-1 min-w-0">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3 gap-4 lg:gap-5 items-stretch">
                <template v-if="isAdmin">
                    <CardBoxWidget :icon="mdiDomain" :number="kpis.ies || 0"
                        label="Instituciones de educación superior" />
                    <CardBoxWidget :icon="mdiFlask" :number="kpis.ci || 0"
                        label="Centros de investigación" />
                    <CardBoxWidget :icon="mdiFactory" :number="kpis.ebt || 0"
                        label="Empresas de base tecnológica" />
                    <CardBoxWidget :icon="mdiHandshakeOutline" :number="kpis.ong || 0"
                        label="Organizaciones no gubernamentales" />
                    <CardBoxWidget :icon="mdiTownHall" :number="kpis.government || 0"
                        label="Dependencias de gobierno" />
                </template>

                <CardBoxWidget v-if="!isAdmin" :icon="mdiGraph" :number="kpis.departments || 0"
                    label="Estructura Organizacional" />
                <CardBoxWidget :icon="mdiCertificate" :number="kpis.institution_certifications || 0"
                    label="Certificaciones" />
                <CardBoxWidget :icon="mdiAccountTie" :number="kpis.academics || 0"
                    label="Académicos" />
                <CardBoxWidget :icon="mdiCubeOutline" :number="kpis.facility_equipment || 0"
                    label="Infraestructura tecnológica" />
                <CardBoxWidget :icon="mdiLinkVariant" :number="kpis.vinculations || 0"
                    label="Proyectos vinculados" />
                <CardBoxWidget :icon="mdiBookEducation" :number="kpis.academic_offerings || 0"
                    label="Oferta educativa" />
                <CardBoxWidget :icon="mdiAccountWrench" :number="kpis.technology_services || 0"
                    label="Servicios tecnológicos" />
                <CardBoxWidget :icon="mdiHandCoin" :number="kpis.requirements || 0"
                    label="Necesidades tecnológicas" />
                <CardBoxWidget :icon="mdiOffer" :number="kpis.capabilities || 0"
                    label="Capacidades tecnológicas" />
                <CardBoxWidget :icon="mdiAccountMultiple" :number="kpis.conferences || 0"
                    label="Conferencias" />
                <CardBoxWidget :icon="mdiLayersSearchOutline" :number="kpis.academics_with_snii || 0"
                    label="SNII" />
                <CardBoxWidget :icon="mdiDomain" :number="kpis.facilities || 0"
                    label="Instalaciones especializadas" />

            </div>
        </div>
    </div>
</template>

<script setup>
import {
    mdiCertificate,
    mdiAccountTie,
    mdiGraph,
    mdiDomain,
    mdiCubeOutline,
    mdiLinkVariant,
    mdiBookEducation,
    mdiHandCoin,
    mdiAccountMultiple,
    mdiAccountWrench,
    mdiLayersSearchOutline,
    mdiOffer,
    mdiFactory,
    mdiFlask,
    mdiTownHall,
    mdiHandshakeOutline
} from '@mdi/js';
import CardBoxWidget from '@/Components/CardBoxWidget.vue';
import HeroSection from './HeroSection.vue';
import { useRole } from '@/Hooks/usePermissions';

const props = defineProps({
    kpis: {
        type: Object,
        default: () => ({
            departments: 0,
            institution_certifications: 0,
            academics: 0,
            facility_equipment: 0,
            projects: 0,
            academic_offerings: 0,
            conferences: 0,
            research_lines: 0,
            academics_with_snii: 0,
            facilities: 0,
            technology_services: 0,
            capabilities: 0,
            requirements: 0,
            vinculations: 0,
            ies: 0,
            ci: 0,
            ebt: 0,
            ong: 0,
            government: 0
        })
    },
    institution: {
        type: Object,
        default: () => ({
            name: '',
            logo: null
        })
    }
});

const isAdmin = useRole('Admin');

</script>
