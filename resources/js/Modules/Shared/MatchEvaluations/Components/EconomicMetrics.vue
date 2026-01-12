<template>
    <FormField label="Impacto Científico-tecnológica" :error="form.errors.economic">
        <MultiSelect v-model="form.economic" :options="impactMetrics.economic" valueKey="id" labelKey="name" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Valor económico estimado" :error="form.errors.economic_estimate">
            <FormControl v-model="form.economic_estimate" type="number" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.economic_estimates">
            <KeywordInput v-model="form.economic_estimates" :limit="255" type="economic_estimates" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Empleos generados directamente" :error="form.errors.direct_jobs_generated">
            <KeywordInput v-model="form.direct_jobs_generated" :limit="255" type="direct_jobs_generated" />
        </FormField>
        <FormField label="Empleos generados indictamente" :error="form.errors.indirect_jobs_generated">
            <KeywordInput v-model="form.indirect_jobs_generated" :limit="255" type="indirect_jobs_generated" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Incremento de productividad (%)" :error="form.errors.productivity_increase">
            <FormControl v-model="form.productivity_increase" type="number" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.productivity_increases">
            <KeywordInput v-model="form.productivity_increases" :limit="255" type="productivity_increases" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Nuevos productos" :error="form.errors.products">
            <KeywordInput v-model="form.products" :limit="255" type="products" />
        </FormField>
        <FormField label="Nuevos Servicios" :error="form.errors.services">
            <KeywordInput v-model="form.services" :limit="255" type="services" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Impacto territorial y regional" :error="form.errors.territorial_level">
            <FormControl v-model="form.territorial_level" :options="territorials" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.territorial_regional">
            <KeywordInput v-model="form.territorial_regional" :limit="255" type="territorial_regional" />
        </FormField>
    </div>
</template>
<script setup>
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import { territorials } from '../Composables/useEnums';

const form = inject('matchEvaluationForm')
const { impactMetrics } = inject('props')
</script>