<template>
    <FormField label="Impacto Científico-tecnológica" :error="form.errors.scientific_technological">
        <MultiSelect v-model="form.scientific_technological" :options="impactMetrics.scientific_technological"
            valueKey="id" labelKey="name" />
    </FormField>

    <FormField label="Publicaciones conjuntas" :error="form.errors.joint_publications">
        <KeywordInput v-model="form.joint_publications" :limit="255" type="joint_publications" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Patentes solicitadas/otorgadas" :error="form.errors.patents">
            <KeywordInput v-model="form.patents" :limit="255" type="patents" />
        </FormField>
        <FormField label="Prototipos" :error="form.errors.prototypes">
            <KeywordInput v-model="form.prototypes" :limit="255" type="prototypes" />
        </FormField>
    </div>

    <FormField label="Software o modelos registrados" :error="form.errors.registered_software">
        <KeywordInput v-model="form.registered_software" :limit="255" type="registered_software" />
    </FormField>

    <FormField label="Incrementa nivel TRL (inicial → final)" :error="form.errors.technology_level_transitions">
        <TechnologyLevelTransition v-model="form.technology_level_transitions" :technologyLevels="technologyLevels"
            :errors="form.errors" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Transferencias tecnológicas" :error="form.errors.technological_transfer_indicators">
            <KeywordInput v-model="form.technological_transfer_indicators" :limit="255"
                type="technological_transfer_indicators" />
        </FormField>
        <FormField label="Tipo de transferencias tecnológicas" :error="form.errors.technological_transfer_metrics">
            <MultiSelect v-model="form.technological_transfer_metrics" :options="impactMetrics.technological_transfer_metrics"
                valueKey="id" labelKey="name" />
        </FormField>
    </div>

    <FormField label="Participación estudiantil / formación">
        <SelectTextInput :options="formations" v-model="form.participations" select-option="level" text-option="name"
            label="participaciones" />
    </FormField>

    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
        <FormField label="Audiencias" :error="form.errors.audiences">
            <MultiSelect v-model="form.audiences" :options="impactMetrics.audiences" valueKey="id" labelKey="name" />
        </FormField>
        <FormField label="Transferencia de conocimiento y capacitación" :error="form.errors.knowledge_training">
            <KeywordInput v-model="form.knowledge_training" :limit="255" type="knowledge_training" />
        </FormField>
    </div>
    <FormField label="Horas totales de capacitación" :error="form.errors.training_hours">
        <FormControl v-model="form.training_hours" type="number" />
    </FormField>
</template>
<script setup>
import MultiSelect from '@/Components/Form/MultiSelect/MultiSelect.vue';
import FormField from '@/Components/FormField.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { inject } from 'vue';
import TechnologyLevelTransition from './Controls/TechnologyLevelTransition.vue';
import FormControl from '@/Components/FormControl.vue';
import SelectTextInput from './Controls/SelectTextInput.vue';
import { formations } from '../Composables/useEnums';

const form = inject('matchEvaluationForm')
const { impactMetrics, technologyLevels } = inject('props')
</script>