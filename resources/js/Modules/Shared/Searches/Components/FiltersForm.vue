<template>
    <FormField class="m-0" label="Palabra clave" :errors="filters.keywords">
        <FormControl placeholder="Busca por título.." v-model="filters.keywords" />
    </FormField>

    <Accordion v-model="activeItems" type="multiple" class="w-full">
        <AccordionItem value="period">
            <AccordionTrigger>Período</AccordionTrigger>
            <AccordionContent>
                <FormField label="Desde" :errors="filters.date_from">
                    <FormControl v-model="filters.date_from" type="date" />
                </FormField>

                <FormField label="Hasta" :errors="filters.date_to">
                    <FormControl v-model="filters.date_to" type="date" />
                </FormField>
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="institution_codes">
            <AccordionTrigger>Tipo de institución</AccordionTrigger>
            <AccordionContent>
                <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.institution_codes"
                    name="institution_codes" :options="institutionTypes" />
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="resource">
            <AccordionTrigger>Tipo de recurso</AccordionTrigger>
            <AccordionContent>
                <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.resource_types" name="resource_types"
                    :options="resourceTypes" />
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="location">
            <AccordionTrigger>Ubicación</AccordionTrigger>
            <AccordionContent>
                <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.municipality_ids" name="municipality_ids"
                    inputKey="id" inputValue="name" :options="municipalities" />
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="ocde">
            <AccordionTrigger>Clasificación OCDE</AccordionTrigger>
            <AccordionContent>
                <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.oecd_sector_ids" name="oecd_sector_ids"
                    inputKey="id" inputValue="name" :options="oecdSectors" />
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="isic">
            <AccordionTrigger>Clasificación ISIC</AccordionTrigger>
            <AccordionContent>
                <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.economic_sector_ids"
                    componentClass="pl-0.5" name="economic_sector_ids" inputKey="id" inputValue="name"
                    :options="economicSectors" />
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="intellectual_property">
            <AccordionTrigger>Propiedad industrial</AccordionTrigger>
            <AccordionContent>
                <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.intellectual_property_ids"
                    name="intellectual_property_ids" inputKey="id" inputValue="name"
                    :options="intellectualProperties" />
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="sni">
            <AccordionTrigger>Sistema Nacional (SNII)</AccordionTrigger>
            <AccordionContent>
                <FormField label="Areas">
                    <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.research_area_ids"
                        name="research_area_ids" inputKey="id" inputValue="name" :options="researchAreas" />
                </FormField>

                <FormField label="Nivel">
                    <FormCheckRadioGroup isColumn type="checkbox" v-model="filters.sni_level_ids" name="sni_level_ids"
                        inputKey="id" inputValue="name" :options="sniLevels" />
                </FormField>
            </AccordionContent>
        </AccordionItem>

        <AccordionItem value="trl">
            <AccordionTrigger>Nivel de madurez (TRL)</AccordionTrigger>
            <AccordionContent>
                <FormField label="TRL Mínimo">
                    <FormControl type="select" v-model="filters.technology_level_min" valueOption="level"
                        :options="techLevels" />
                </FormField>

                <FormField label="TRL Máximo">
                    <FormControl type="select" v-model="filters.technology_level_max" valueOption="level"
                        :options="techLevels" />
                </FormField>
            </AccordionContent>
        </AccordionItem>
    </Accordion>
</template>

<script setup>
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/Components/ui/accordion';
import { institutionTypes } from '@/Utils/institutions.js';
import { onBeforeMount, onBeforeUnmount, ref } from 'vue';

const props = defineProps({
    filters: {
        type: Object,
        required: true
    },
    filterOptions: {
        type: Object,
        required: true
    }
});

const {
    economicSectors,
    municipalities,
    oecdSectors,
    researchAreas,
    sniLevels,
    techLevels,
    intellectualProperties
} = props.filterOptions;

const resourceTypes = {
    academic: 'Académicos/Investigadores',
    capability: 'Capacidades tecnológicas',
    research_center: 'Centros de investigación',
    institution_certification: 'Certificaciones',
    conference: 'Conferencias',
    academic_body: 'Cuerpo académico',
    government_agency: 'Dependencias de gobierno',
    company: 'Empresas',
    equipment: 'Infraestructura tecnológica',
    facility: 'Instalaciones especializadas',
    higher_education: 'Instituciones de educación superior',
    research_line: 'Líneas de investigación',
    requirement: 'Necesidades tecnológicas',
    academic_offering: 'Oferta educativa',
    job_offer: 'Oferta laboral',
    non_profit: 'Organizaciones no gubernamentales',
    technology_service: 'Servicios tecnológicos',
};

const activeItems = ref(null);
const STORAGE_KEY = 'accordion_state';

onBeforeMount(() => {
    const savedState = localStorage.getItem(STORAGE_KEY);
    if (!savedState) return;

    try {
        activeItems.value = JSON.parse(savedState);
    } catch (e) {
        activeItems.value = ['resource'];
    }
});

onBeforeUnmount(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(activeItems.value));
});
</script>