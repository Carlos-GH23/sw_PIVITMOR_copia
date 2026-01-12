<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShapeOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Reconocimientos SNII y Perfil deseable
                    </h3>
                    <span class="text-sm font-light text-slate-800">
                        Detalles sobre el Sistema Nacional de Investigadoras e Investigadores y el perfil deseable
                    </span>
                </div>
            </div>
        </template>

        <CardSection :hasDivider="false" title="SNII" description="Sistema Nacional de Investigadoras e Investigadores"
            :icon="mdiAccountTie">

            <ToggleYesOrNot v-model="form.sni.has_sni" label="Cuenta con SNII:" />
            <div v-if="form.sni.has_sni" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <FormField label="Número de CVU" :error="props.errors?.['sni.number']">
                        <FormControl type="text" placeholder="Número de identificación (Opcional)"
                            v-model="form.sni.number" />
                    </FormField>
                    <FormField label="Nivel" :error="props.errors?.['sni.sni_level_id']">
                        <FormControl type="select" placeholder="Seleccione un nivel" v-model="form.sni.sni_level_id"
                            :options="sniiLevels" :icon="mdiFormatListNumbered" />
                    </FormField>
                    <FormField label="Áreas" :error="props.errors?.['sni.research_area_id']">
                        <FormControl type="select" placeholder="Seleccione un área" v-model="form.sni.research_area_id"
                            :options="researchAreas" />
                    </FormField>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <FormField label="Fecha de inicio" :error="props.errors?.['sni.start_date']">
                        <FormControl type="date" v-model="form.sni.start_date" :icon="mdiCalendar" />
                    </FormField>
                    <FormField label="Fecha fin" :error="props.errors?.['sni.end_date']">
                        <FormControl type="date" v-model="form.sni.end_date" :icon="mdiCalendar" />
                    </FormField>
                </div>
            </div>
        </CardSection>

        <CardSection title="PRODEP" description="Programa para el Desarrollo Profesional Docente"
            :icon="mdiAccountTieWoman">
            <ToggleYesOrNot v-model="form.profile.has_profile" label="Cuenta con perfil deseable:" />
            <div v-if="form.profile.has_profile" class="grid md:grid-cols-2 gap-4">
                <FormField label="Fecha de inicio" :error="props.errors?.['profile.start_date']">
                    <FormControl type="date" v-model="form.profile.start_date" :icon="mdiCalendar" />
                </FormField>
                <FormField label="Fecha fin" :error="props.errors?.['profile.end_date']">
                    <FormControl type="date" v-model="form.profile.end_date" :icon="mdiCalendar" />
                </FormField>
            </div>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import ToggleYesOrNot from '@/Components/ToggleYesOrNot.vue';
import { mdiAccountTie, mdiAccountTieWoman, mdiCalendar, mdiFormatListNumbered, mdiShapeOutline } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const props = inject('props');
const researchAreas = inject('researchAreas');
const sniiLevels = inject('sniiLevels');
</script>
