<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiLayersSearch" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        SNII
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos del Sistema Nacional de Investigadoras e Investigadores.
                    </p>
                </div>
            </div>
        </template>

        <ToggleYesOrNot v-model="form.sni.has_sni" label="Cuenta con SNII:" />

        <div v-if="form.sni.has_sni" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <FormField label="Número de CVU" :error="form.errors?.['sni.number']">
                    <FormControl type="text" placeholder="Número de identificación (Opcional)"
                        v-model="form.sni.number" />
                </FormField>
                <FormField label="Nivel:" :error="form.errors?.['sni.sni_level_id']">
                    <FormControl v-model="form.sni.sni_level_id" type="select" :options="sniiLevels" />
                </FormField>
                <FormField label="Área:" :error="form.errors?.['sni.research_area_id']">
                    <FormControl v-model="form.sni.research_area_id" type="select" :options="sniiAreas" />
                </FormField>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <FormField label="Fecha de inicio:" :error="form.errors?.['sni.start_date']">
                    <FormControl v-model="form.sni.start_date" type="date" :icon="mdiCalendar" />
                </FormField>
                <FormField label="Fecha fin:" :error="form.errors?.['sni.end_date']">
                    <FormControl v-model="form.sni.end_date" type="date" :icon="mdiCalendar" />
                </FormField>
            </div>
        </div>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import FormField from '@/Components/FormField.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiCalendar, mdiLayersSearch } from '@mdi/js';
import CardForm from '@/Components/CardForm.vue';
import ToggleYesOrNot from '@/Components/ToggleYesOrNot.vue';

const form = inject('form')
const sniiAreas = inject('sniiAreas')
const sniiLevels = inject('sniiLevels')

</script>