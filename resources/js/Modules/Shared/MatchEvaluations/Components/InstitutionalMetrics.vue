<template>
    <FormField label="Percepción y satisfacción" :error="form.errors.institutional">
        <MultiSelect v-model="form.institutional" :options="impactMetrics.institutional" valueKey="id"
            labelKey="name" />
    </FormField>

    <FormField label="Alianzas y convenios" :error="form.errors.partnership_agreements">
        <SelectTextInput :options="agreementTypes" v-model="form.partnership_agreements" select-option="agreement_type"
            text-option="name" label="Alianzas y convenios" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4">
        <FormField label="Fortalecimiento de infraestructura" :error="form.errors.infrastructure_level">
            <FormControl v-model="form.infrastructure_level" :options="infrastructureLevels" />
        </FormField>
        <FormField label="Inversión estimada" :error="form.errors.estimated_investment">
            <FormControl v-model="form.estimated_investment" type="number" />
        </FormField>
        <FormField label="Evidencia cualitativa" :error="form.errors.infrastructure_strengthening">
            <KeywordInput v-model="form.infrastructure_strengthening" :limit="255"
                type="infrastructure_strengthening" />
        </FormField>
    </div>

    <FormField label="Programas académicos vinculados" :error="form.errors.academic_offerings">
        <MultiSelect v-model="form.academic_offerings" :options="academicOfferings" valueKey="id" labelKey="name" />
    </FormField>

    <FormField label="Participación en redes / clusters" :error="form.errors.network_participation">
        <KeywordInput v-model="form.network_participation" :limit="255" type="network_participation" />
    </FormField>

    <FormField label="Reconocimientos institucionales" :error="form.errors.recognitions">
        <InstitutionalRecognitions v-model="form.recognitions" :errors="form.errors" />
    </FormField>

    <CardSection title="Madurez de la vinculación intersectorial"
        description="Califique la madurez de la vinculación intersectorial">
        <FormField label="Nivel de madurez" :error="form.errors.maturity_level">
            <RatingSlider v-model="form.maturity_level" />
        </FormField>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
            <FormField label="Estructura de gobernanza" :error="form.errors.structure_type">
                <FormControl v-model="form.structure_type" :options="governanceStructure" />
            </FormField>
            <FormField label="Evidencia cualitativa" :error="form.errors.intersectoral_linkage_maturity">
                <KeywordInput v-model="form.intersectoral_linkage_maturity" :limit="255"
                    type="intersectoral_linkage_maturity" />
            </FormField>
        </div>
    </CardSection>
</template>
<script setup>
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { inject } from 'vue';
import FormControl from '@/Components/FormControl.vue';
import { agreementTypes, governanceStructure, infrastructureLevels } from '../Composables/useEnums';
import RatingSlider from './Controls/RatingSlider.vue';
import SelectTextInput from './Controls/SelectTextInput.vue';
import InstitutionalRecognitions from './Controls/InstitutionalRecognitions.vue';
import CardSection from '@/Components/CardSection.vue';

const form = inject('matchEvaluationForm')
const { impactMetrics, academicOfferings } = inject('props')
</script>