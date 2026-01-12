<template>
    {{ form.errors }}
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCheckCircle" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Resumen de Confirmación
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Revisa la información antes de enviar tu solicitud
                    </p>
                </div>
            </div>
        </template>

        <div class="grid gap-4">
            <LabelText label="Título" :text="form.title" />
            <LabelText label="Descripción" :text="form.technical_description" />
            <LabelText label="Problema que resuelve" :text="form.need_statement" />
            <LabelText label="Aplicaciones potenciales" :text="form.potential_applications" />
        </div>

        <CardSection title="Detalles técnicos" :icon="mdiCogOutline">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4 mb-4">
                <FormField label="Propiedad Intelectual" :error="form.errors.intellectual_property_id">
                    <FormControl v-model="form.intellectual_property_id" :options="intellectuals" />
                </FormField>
                <FormField label="Nivel de madurez tecnológica" :error="form.errors.technology_level_id">
                    <FormControl v-model="form.technology_level_id" :options="technologies" />
                </FormField>
                <FormField v-if="department" label="Departamento">
                    <LabelControl :value="department.name" disabled />
                </FormField>
                <FormField label="Fecha de inicio" :error="form.errors.start_date">
                    <FormControl v-model="form.start_date" type="date" />
                </FormField>
                <FormField label="Fecha fin" :error="form.errors.end_date">
                    <FormControl v-model="form.end_date" type="date" />
                </FormField>
            </div>
        </CardSection>

        <BaseDivider />

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <CardSelectable :icon="mdiHammerWrench" title="Sectores económicos y productivos (ISIC)"
                v-model="form.oecd_sectors" :items="flattenChildren.oecdSectors" />
            <CardSelectable :icon="mdiAtom" title="Disciplinas científicas y tecnológicas (OCDE)"
                v-model="form.economic_sectors" :items="flattenChildren.sectors" />
        </div>
    </CardForm>
</template>
<script setup>
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardForm from "@/Components/CardForm.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import { mdiAtom, mdiCheckCircle, mdiCogOutline, mdiHammerWrench } from "@mdi/js";
import { computed, inject } from "vue";
import LabelText from "@/Components/LabelText.vue";
import CardSection from "@/Components/CardSection.vue";
import CardSelectable from "@/Components/CardSelectable.vue";
import LabelControl from "@/Components/LabelControl.vue";

const form = inject('requirementForm')
const { department, intellectuals, technologies, oecdSectors, economicSectors } = inject('props');

const flattenChildren = computed(() => ({
    oecdSectors: (oecdSectors || []).flatMap(function flatten(item) {
        return [item, ...(item.children || []).flatMap(flatten)];
    }),
    sectors: (economicSectors || []).flatMap(function flatten(item) {
        return [item, ...(item.children || []).flatMap(flatten)];
    }),
}));
</script>