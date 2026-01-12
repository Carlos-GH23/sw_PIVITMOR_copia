<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiCheckCircle" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Resumen de Confirmación
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Revisa la información antes de crear la oferta educativa
                    </p>
                </div>
            </div>
        </template>
        <div class="grid gap-4">
            <LabelText label="Título" :text="form.name" />
            <LabelText label="Descripción" :text="form.description" />
            <LabelText label="Objetivo" :text="form.objective" />
            <LabelText label="Perfil de Egreso" :text="form.graduate_profile" />
        </div>

        <CardSection title="Detalles de la oferta" :icon="mdiCogOutline">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4 mb-4">
                <FormField label="Nivel" :error="form.errors.educational_level_id">
                    <FormControl type="select" v-model="form.educational_level_id" :options="educationalLevels"
                        :readonly="true" />
                </FormField>
                <FormField label="Modalidad" :error="form.errors.study_mode_id">
                    <FormControl type="select" v-model="form.study_mode_id" :options="studyModes" :readonly="true" />
                </FormField>
                <FormField label="Departamento" :error="form.errors.department_id">
                    <FormControl type="select" v-model="form.department_id" :options="departments" :readonly="true" />
                </FormField>
                <LabelText label="Página Web" :text="form.website" />
                <LabelText label="Costo del Semestre" :text="form.semester_cost" />
                <LabelText label="Duración (meses)" :text="form.duration_months" />
                <LabelText label="REVOE" :text="form.revoe" />
            </div>
        </CardSection>
        <BaseDivider />
        <CardSection title="Acreditaciones">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <FormField label="Acreditación COPAES" class="text-sm font-semibold text-gray-700"
                    :error="form.errors.copaes_accreditation_id">
                    <FormControl type="select" v-model="form.copaes_accreditation_id" :options="copaesAccreditations"
                        :readonly="true"
                        class="rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </FormField>

                <FormField label="Acreditación CIEES" class="text-sm font-semibold text-gray-700"
                    :error="form.errors.ciees_accreditation_id">
                    <FormControl type="select" v-model="form.ciees_accreditation_id" :options="cieesAccreditations"
                        :readonly="true"
                        class="rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </FormField>

                <FormField label="Acreditación FIMPES" class="text-sm font-semibold text-gray-700"
                    :error="form.errors.fimpes_accreditation_id">
                    <FormControl type="select" v-model="form.fimpes_accreditation_id" :options="fimpesAccreditations"
                        :readonly="true"
                        class="rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </FormField>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <FormField v-if="form.copaes_type" label="Vigencia COPAES" class="text-sm font-semibold text-gray-700"
                    :error="form.errors.copaes_expiry_date">
                    <FormControl type="date" v-model="form.copaes_expiry_date" :readonly="true"
                        class="rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </FormField>

                <FormField v-if="form.ciees_type" label="Nivel CIEES" class="text-sm font-semibold text-gray-700"
                    :error="form.errors.ciees_level">
                    <FormControl v-model="form.ciees_level" :readonly="true"
                        class="rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </FormField>

                <FormField v-if="form.ciees_type" label="Vigencia CIEES" class="text-sm font-semibold text-gray-700"
                    :error="form.errors.ciees_expiry_date">
                    <FormControl type="date" v-model="form.ciees_expiry_date" :readonly="true"
                        class="rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </FormField>
            </div>
        </CardSection>
        <BaseDivider />
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <CardSelectable :icon="mdiHammerWrench" title="Sectores Económicos (ISIC)" :values="form.economic_sectors"
                :items="economicSectors" />
            <CardSelectable :icon="mdiAtom" title="Disciplinas OCDE" :values="form.oecd_sectors" :items="oecdSectors" />
        </div>
    </CardForm>
</template>

<script setup>
import { inject } from 'vue';
import CardForm from '@/Components/CardForm.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiAtom, mdiCheckCircle, mdiCogOutline, mdiHammerWrench, mdiTag } from "@mdi/js";
import CardSection from "@/Components/CardSection.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import CardSelectable from './CardSelectable.vue';
import LabelText from '@/Components/LabelText.vue';

const form = inject('form');
const educationalLevels = inject('educationalLevels');
const studyModes = inject('studyModes');
const departments = inject('departments');
const oecdSectors = inject('oecdSectors');
const economicSectors = inject('economicSectors');
const copaesAccreditations = inject('copaesAccreditations');
const cieesAccreditations = inject('cieesAccreditations');
const fimpesAccreditations = inject('fimpesAccreditations');
</script>