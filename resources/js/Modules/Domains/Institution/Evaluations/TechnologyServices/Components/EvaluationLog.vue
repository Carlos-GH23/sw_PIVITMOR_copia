<template>
    <CardBox padding="px-4 md:px-2" v-if="technologyService?.assessments?.length > 0" class="lg:max-h-96 overflow-y-auto">
        <div class="sticky -top-1 bg-white z-10 mb-4 lg:py-2">
            <h3 class="text-base text-forest-400 font-semibold">Registro de comentarios</h3>
            <span class="text-sm text-gray-500">Historial de comentarios de la solicitud</span>
        </div>

        <AssessmentRecords :assessments="technologyService.assessments" />
    </CardBox>
</template>

<script setup>
import AssessmentRecords from '@/Components/AssessmentRecords.vue';
import CardBox from '@/Components/CardBox.vue';
import { inject } from 'vue';

const technologyService = inject('technologyService');
</script>
