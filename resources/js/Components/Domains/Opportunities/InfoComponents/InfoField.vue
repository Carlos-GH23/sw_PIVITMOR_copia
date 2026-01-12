<template>
    <LabelText v-if="value" :label="label" :text="value" />
</template>

<script setup>
import LabelText from '@/Components/LabelText.vue';

defineProps({
    label: {
        type: String,
        required: true
    },
    value: {
        type: [String, Number],
        default: null
    }
});
</script>