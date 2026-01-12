<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiShape" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Clasificación
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Taxonomía y etiquetas
                    </p>
                </div>
            </div>
        </template>
        <FormField label="Disciplinas científicas y tecnológicas (OCDE):">
            <HierarchicalSelector v-model="form.oecd_sectors" :items="props.oecdSectors"
                placeholder="Buscar disciplinas científicas y tecnológicas (OCDE)..."
                :level-labels="['Área Principal', 'Subárea', 'Disciplina']" />
            <template #tooltip>
                <li>Seleccione las disciplinas científicas y tecnológicas más relevantes para la oferta.</li>
            </template>
        </FormField>

        <FormField label="Sectores económicos y productivos (ISIC):">
            <HierarchicalSelector v-model="form.economic_sectors" :items="props.economicSectors"
                placeholder="Buscar sectores económicos y productivos (ISIC)..."
                :level-labels="['Sección', 'División', 'Grupo']" />
            <template #tooltip>
                El capital humano relacionado con la oferta tecnológica, puede relacionar al creador autor intelectual
                de dicha tecnología.
            </template>
        </FormField>
    </CardForm>
</template>
<script setup>
import CardForm from "@/Components/CardForm.vue";
import FormField from "@/Components/FormField.vue";
import { inject } from "vue";
import HierarchicalSelector from "@/Components/Form/HierarchicalSelector/HierarchicalSelector.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import { mdiShape } from "@mdi/js";

const props = defineProps({
    oecdSectors: {
        type: Array,
        default: () => []
    },
    economicSectors: {
        type: Array,
        default: () => []
    }
});

const form = inject("formJobOffer")
</script>