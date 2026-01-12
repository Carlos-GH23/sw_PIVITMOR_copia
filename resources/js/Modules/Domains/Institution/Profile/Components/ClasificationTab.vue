<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación y categorización
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Clasificación y categorización de la institución
                    </p>
                </div>
            </div>
        </template>
        <div class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <FormField label="Disciplinas científicas y tecnológicas (OCDE)">
                    <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                        placeholder="Buscar área, subárea o disciplina..."
                        :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
                </FormField>

                <FormField label="Sectores económicos y productivos (ISIC)">
                    <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                        placeholder="Buscar sección, división o grupo..."
                        :level-labels="['Sección', 'División', 'Grupo']" />
                    <template #tooltip>
                        El capital humano relacionado con la oferta tecnológica, puede relacionar al creador autor
                        intelectual de dicha tecnología.
                    </template>
                </FormField>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <FormField label="Áreas de conocimiento">
                    <SearchSelect v-model="form.knowledge_areas" itemsKey="children" :items="knowledges"
                        placeholder="Buscar áreas de conocimiento..." />
                </FormField>
            </div>
        </div>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import CardForm from '@/Components/CardForm.vue';
import { mdiShape } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import FormField from '@/Components/FormField.vue';
import SearchSelect from '@/Components/SearchSelect.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';

const form = inject('form');
const oecdSectors = inject('oecdSectors');
const economicSectors = inject('economicSectors');
const knowledges = inject('knowledges');

</script>
