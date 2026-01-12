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
        <div class="grid md:grid-cols gap-4">
            <FormField label="Disciplinas científicas y tecnológicas (OCDE)" :error="form.errors.oecd_sectors">
                <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                    placeholder="Buscar área, subárea o disciplina..."
                    :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
            </FormField>
        </div>

        <div class="grid md:grid-cols gap-4">
            <FormField label="Sectores económicos y productivos (ISIC)" :error="form.errors.economic_sectors">
                <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                    placeholder="Buscar sección, división o grupo..."
                    :level-labels="['Sección', 'División', 'Grupo']" />
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';
import { mdiShape } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const oecdSectors = inject('oecdSectors');
const economicSectors = inject('economicSectors');

</script>