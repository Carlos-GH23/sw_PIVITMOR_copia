<template>
    <CardBox padding="px-4 md:px-2">
        <div class="sticky -top-1 bg-white z-10 mb-4 lg:py-2">
            <h3 class="text-base text-forest-400 font-semibold">Registro de comentarios</h3>
            <span class="text-sm text-gray-500">Historial de comentarios de la solicitud</span>
        </div>

        <div class="max-h-96 overflow-y-auto px-1">
            <AssessmentRecords :assessments="assessments" />
        </div>
    </CardBox>
</template>

<script setup>
import AssessmentRecords from '@/Components/AssessmentRecords.vue';
import CardBox from '@/Components/CardBox.vue';

defineProps({
    assessments: {
        type: Array,
        default: () => []
    }
})
</script>