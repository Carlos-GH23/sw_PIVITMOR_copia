<template>
    <FormField label="Percepción y satisfacción" :error="form.errors.public_innovation">
        <MultiSelect v-model="form.public_innovation" :options="impactMetrics.public_innovation" valueKey="id"
            labelKey="name" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Mejora en servicios públicos" :error="form.errors.public_service_percentage">
            <FormControl v-model="form.public_service_percentage" type="number" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.public_services">
            <KeywordInput v-model="form.public_services" :limit="255" type="public_services" />
        </FormField>
    </div>

    <CardSection title="Digitalización y simplificación" description="Indique políticas o normativas derivadas">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4 mb-6">
            <div class="">
                <FormField label="Digitalización de proceso (%)" :error="form.errors.process_digitalization_percentage">
                    <FormControl v-model="form.process_digitalization_percentage" type="number" />
                </FormField>
                <FormField label="Porcentaje de simplificación (trámites/pasos menos)"
                    :error="form.errors.process_simplification_percentage">
                    <FormControl v-model="form.process_simplification_percentage" type="number" />
                </FormField>
            </div>
            <FormField label="Interoperabilidad" :error="form.errors.interoperability_level">
                <FormControl v-model="form.interoperability_level" :options="interoperabilityLevels" />
            </FormField>
            <FormField label="Evidencia cualitativa" :error="form.errors.digitalization_and_simplification">
                <KeywordInput v-model="form.digitalization_and_simplification" :limit="255"
                    type="digitalization_and_simplification" />
            </FormField>
        </div>
        <BaseDivider />
    </CardSection>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Transparencia y datos abiertos" :error="form.errors.transparency_level">
            <FormControl v-model="form.transparency_level" :options="transparencyLevels" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.data_transparency">
            <KeywordInput v-model="form.data_transparency" :limit="255" type="data_transparency" />
        </FormField>
    </div>

    <FormField label="Replicabilidad regional" :error="form.errors.regional_replicability">
        <KeywordInput v-model="form.regional_replicability" :limit="255" type="regional_replicability" />
    </FormField>

    <CardSection title="Políticas o normativas derivadas" description="Indique políticas o normativas derivadas">
        <DerivedPolicies v-model="form.derived_policies" :errors="form.errors" />
    </CardSection>
</template>
<script setup>
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import { interoperabilityLevels, transparencyLevels } from '../Composables/useEnums';
import CardSection from '@/Components/CardSection.vue';
import DerivedPolicies from './Controls/DerivedPolicies.vue';
import BaseDivider from '@/Components/BaseDivider.vue';

const form = inject('matchEvaluationForm')
const { impactMetrics } = inject('props')
</script>