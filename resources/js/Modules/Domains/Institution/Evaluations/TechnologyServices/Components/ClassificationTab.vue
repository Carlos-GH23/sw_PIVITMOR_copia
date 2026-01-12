<template>
    <CardForm v-if="service">
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación y Categorización
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Taxonomía, etiquetas y recursos asociados
                    </p>
                </div>
            </div>
        </template>
        <div class="space-y-6">
            <CardSelectable :icon="mdiHammerWrench" title="Sectores económicos y productivos (ISIC)"
                :items="service.economic_sectors" :is-filtered="false" />
            <CardSelectable :icon="mdiAtom" title="Disciplinas científicas y tecnológicas (OCDE)"
                :items="service.oecd_sectors" :is-filtered="false" />
            <CardSelectable :icon="mdiAccountGroup" title="Recursos Humanos" :items="service.academics"
                :is-filtered="false" />
            <CardSelectable :icon="mdiHome" title="Infraestructura" :items="service.facilities" :is-filtered="false" />
            <CardSelectable :icon="mdiHammerWrench" title="Recursos Tecnológicos" :items="service.equipments"
                :is-filtered="false" />
            <CardSection title="Periodo de publicación" description="Periodo de publicación del servicio tecnológico"
                iconClasses="bg-forest-400 text-mono-100" :icon="mdiCalendarBlankOutline">
                <div class="md:grid grid-cols-2 gap-4">
                    <FormField label="Fecha de inicio">
                        <LabelControl :value="service.start_date?.formatted" />
                    </FormField>
                    <FormField label="Fecha de cierre">
                        <LabelControl :value="service.end_date?.formatted" />
                    </FormField>
                </div>
            </CardSection>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import CardSelectable from '@/Components/CardSelectable.vue';
import FormField from '@/Components/FormField.vue';
import LabelControl from '@/Components/LabelControl.vue';
import { mdiAccountGroup, mdiAtom, mdiCalendarBlankOutline, mdiHammerWrench, mdiHome, mdiShape } from '@mdi/js';
import { inject } from 'vue';

const service = inject('technologyService');
</script>
