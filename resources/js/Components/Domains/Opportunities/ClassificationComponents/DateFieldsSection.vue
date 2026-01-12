<template>
    <CardSection v-if="type !== 'conference' && hasPublicationPeriod" title="Periodo de publicación"
        :description="periodDescription" :hasDivider="false">
        <div class="grid grid-cols-2 gap-4">
            <FormField v-if="opportunity.start_date" label="Fecha de inicio">
                <LabelControl :value="formatDate(opportunity.start_date)" />
            </FormField>

            <FormField v-if="opportunity.end_date" label="Fecha de cierre">
                <LabelControl :value="formatDate(opportunity.end_date)" />
            </FormField>
        </div>
    </CardSection>

    <template v-if="type === 'conference'">
        <div v-if="hasConferenceDates" class="grid grid-cols-2 gap-4">
            <FormField v-if="opportunity.start_date" label="Fecha de inicio">
                <LabelControl :value="opportunity.start_date" />
            </FormField>
            <FormField v-if="opportunity.end_date" label="Fecha de fin">
                <LabelControl :value="opportunity.end_date" />
            </FormField>
        </div>

        <div v-if="hasConferenceTimes" class="grid grid-cols-2 gap-4">
            <FormField v-if="opportunity.start_time" label="Hora de inicio">
                <LabelControl :value="opportunity.start_time" />
            </FormField>
            <FormField v-if="opportunity.end_time" label="Hora de fin">
                <LabelControl :value="opportunity.end_time" />
            </FormField>
        </div>
    </template>
</template>

<script setup>
import CardSection from '@/Components/CardSection.vue';
import FormField from '@/Components/FormField.vue';
import LabelControl from '@/Components/LabelControl.vue';
import { computed } from 'vue';
import { periodDescriptions } from '@/Configs/opportunityClassificationConfig';

const props = defineProps({
    opportunity: {
        type: Object,
        required: true
    },
    type: {
        type: String,
        required: true
    }
});

const periodDescription = computed(() => {
    return periodDescriptions[props.type] || 'Periodo de publicación del recurso';
});

const hasPublicationPeriod = computed(() => {
    return props.opportunity.start_date || props.opportunity.end_date;
});

const hasConferenceDates = computed(() => {
    return props.opportunity.start_date || props.opportunity.end_date;
});

const hasConferenceTimes = computed(() => {
    return props.opportunity.start_time || props.opportunity.end_time;
});

function formatDate(dateObj) {
    return dateObj?.human || dateObj?.formatted || dateObj;
}
</script>