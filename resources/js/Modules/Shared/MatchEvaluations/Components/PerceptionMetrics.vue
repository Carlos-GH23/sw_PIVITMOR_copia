<template>
    <FormField label="Percepción y satisfacción" :error="form.errors.perception_satisfaction">
        <MultiSelect v-model="form.perception_satisfaction" :options="impactMetrics.perception_satisfaction"
            valueKey="id" labelKey="name" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Satisfacción vinculación" :error="form.errors.rating">
            <RatingSlider v-model="form.rating" />
        </FormField>
        <FormField label="Evidencia cualitativa">
            <KeywordInput v-model="form.linking_satisfaction" :limit="255" type="linking_satisfaction" />
        </FormField>
    </div>

    <FormField label="Testimonios cualitativos" help="5 testimonios máximos" :error="form.errors.testimonials">
        <Testimonials v-model="form.testimonials" :errors="form.errors" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4">
        <FormField label="Continuidad de colaboración(%)" :error="form.errors.continuity_percentage">
            <FormControl v-model="form.continuity_percentage" type="number" />
        </FormField>
        <FormField label="Tipo de continuidad" :error="form.errors.continuity_type">
            <FormControl v-model="form.continuity_type" :options="continuityTypes" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.collaboration_continuity">
            <KeywordInput v-model="form.collaboration_continuity" :limit="255" type="collaboration_continuity" />
        </FormField>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
        <FormField label="Satisfacción vinculación" :error="form.errors.communication_management_percentage">
            <FormControl v-model="form.communication_management_percentage" type="number" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.communication_management">
            <KeywordInput v-model="form.communication_management" :limit="255" type="communication_management" />
        </FormField>
    </div>
</template>
<script setup>
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import { continuityTypes } from '../Composables/useEnums';
import RatingSlider from './Controls/RatingSlider.vue';
import Testimonials from './Controls/Testimonials.vue';

const form = inject('matchEvaluationForm')
const { impactMetrics } = inject('props')
</script>