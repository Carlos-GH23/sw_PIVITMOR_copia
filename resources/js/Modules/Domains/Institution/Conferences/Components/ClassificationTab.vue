<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación y Categorización
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Taxonomía y etiquetas
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <div class="grid grid-cols-1">
                <FormField label="Disciplinas científicas y tecnológicas (OCDE)" required
                    :error="form.errors.oecd_sectors">
                    <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                        placeholder="Buscar disciplinas científicas y tecnológicas (OCDE)..."
                        :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
                </FormField>
            </div>

            <div class="grid md:grid-cols gap-4">
                <FormField label="Sectores económicos y productivos (ISIC)" :error="form.errors.economic_sectors">
                    <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                        placeholder="Buscar sectores económicos y productivos (ISIC)..."
                        :level-labels="['Sección', 'División', 'Grupo']" />
                </FormField>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6">
                <FormField label="Tipo de audiencia" required :error="form.errors.audience_types">
                    <MultiSelect value-key="id" label-key="type" v-model="form.audience_types"
                        :options="audienceTypes" />
                </FormField>
                <FormField label="Modalidad" required :error="form.errors.modality">
                    <FormControl type="select" valueSelect="value" valueOption="label" v-model="form.modality"
                        :options="modality" />
                </FormField>
            </div>
        </div>
    </CardForm>
</template>
<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormControl from '@/Components/FormControl.vue';
import { inject } from 'vue';
import { mdiShape } from '@mdi/js';

const form = inject('conferenceForm');
const oecdSectors = inject('oecdSectors', []);
const economicSectors = inject('economicSectors', []);
const audienceTypes = inject('audienceTypes', []);
const modality = inject('modality', []);
</script>