<template>
    <FormField label="Impacto social y ambiental" :error="form.errors.social_environmental">
        <MultiSelect v-model="form.social_environmental" :options="impactMetrics.social_environmental" valueKey="id"
            labelKey="name" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Beneficiarios directos" :error="form.errors.direct_beneficiaries">
            <KeywordInput v-model="form.direct_beneficiaries" :limit="255" type="direct_beneficiaries" />
        </FormField>
        <FormField label="Beneficiarios indirectos" :error="form.errors.indirect_beneficiaries">
            <KeywordInput v-model="form.indirect_beneficiaries" :limit="255" type="indirect_beneficiaries" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4">
        <FormField label="Reducción de emisiones(tCO2/año)" :error="form.errors.emissions_percentage">
            <FormControl v-model="form.emissions_percentage" :options="emissionsPercentage" />
        </FormField>
        <FormField label="Metodología" :error="form.errors.emissions_methodology">
            <FormControl v-model="form.emissions_methodology" :options="methodologies" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.carbon_emissions">
            <KeywordInput v-model="form.carbon_emissions" :limit="255" type="carbon_emissions" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Impacto comunitario" :error="form.errors.community_impact_level">
            <FormControl v-model="form.community_impact_level" :options="IntensityLevels" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.community_impact">
            <KeywordInput v-model="form.community_impact" :limit="255" type="community_impact" />
        </FormField>
    </div>

    <FormField label="Objetivos de Desarrollo Sostenible (ODS) relacionados" :error="form.errors.sustainable_development_goals">
        <MultiSelect v-model="form.sustainable_development_goals" :options="impactMetrics.sustainable_development_goals"
            valueKey="id" labelKey="name" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Inclusión y equidad" :error="form.errors.inclusion_equity_level">
            <FormControl v-model="form.inclusion_equity_level" :options="IntensityLevels" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.inclusion_equity">
            <KeywordInput v-model="form.inclusion_equity" :limit="255" type="inclusion_equity" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Sostenibilidad del proyecto" :error="form.errors.project_sustainability_status">
            <FormControl v-model="form.project_sustainability_status" :options="sustainabilityStatuses" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.project_sustainability">
            <KeywordInput v-model="form.project_sustainability" :limit="255" type="project_sustainability" />
        </FormField>
    </div>
</template>
<script setup>
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import { emissionsPercentage, IntensityLevels, methodologies, sustainabilityStatuses } from '../Composables/useEnums';

const form = inject('matchEvaluationForm')
const { impactMetrics } = inject('props')
</script>