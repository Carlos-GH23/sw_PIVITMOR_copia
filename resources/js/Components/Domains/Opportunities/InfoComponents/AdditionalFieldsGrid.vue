<template>
    <div v-if="hasCostOrDuration" class="grid grid-cols-2 gap-4">
        <FormField v-if="opportunity.semester_cost" label="Costo por semestre">
            <LabelControl :value="`$${opportunity.semester_cost}`" />
        </FormField>
        <FormField v-if="opportunity.duration_months" label="Duración (meses)">
            <LabelControl :value="opportunity.duration_months" />
        </FormField>
    </div>
</template>

<script setup>
import FormField from '@/Components/FormField.vue';
import LabelControl from '@/Components/LabelControl.vue';
import { computed } from 'vue';

const props = defineProps({
    opportunity: {
        type: Object,
        required: true
    }
});

const hasCostOrDuration = computed(() => {
    return props.opportunity.semester_cost || props.opportunity.duration_months;
});
</script>