<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShapeOutline" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <h3 class="text-forest-400 text-xl font-bold">
                        Disciplinas y sectores económicos
                    </h3>
                    <span class="text-sm font-light text-slate-800">
                        Proporciona las disciplinas y los sectores económicos relacionados con tu perfil académico
                    </span>
                </div>
            </div>
        </template>
        <div class="grid md:grid-cols-2 gap-4">
            <FormField label="Disciplinas científicas y tecnológicas (OCDE)" required :error="form.errors.oecd_sectors">
                <HierarchicalSelector v-model="form.oecd_sectors" :items="oecdSectors"
                    placeholder="Buscar área, subárea o disciplina..."
                    :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
            </FormField>

            <FormField label="Sectores económicos y productivos (ISIC)" required :error="form.errors.economic_sectors">
                <HierarchicalSelector v-model="form.economic_sectors" :items="economicSectors"
                    placeholder="Buscar sección, división o grupo..."
                    :level-labels="['Sección', 'División', 'Grupo']" />
                <template #tooltip>
                    El capital humano relacionado con la oferta tecnológica, puede relacionar al creador autor
                    intelectual de dicha tecnología.
                </template>
            </FormField>
        </div>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import FormField from '@/Components/FormField.vue';
import HierarchicalSelector from '@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue';
import { mdiShapeOutline } from '@mdi/js';
import { inject } from 'vue';

const form = inject('form');
const oecdSectors = inject('oecdSectors');
const economicSectors = inject('economicSectors');
</script>
