<template>
    <CardBox>
        <FileUploadSection title="Recursos Asociados"
            description="Proporciona recursos adicionales para la oferta educativa." :form="form"
            :has-divider="false" />
    </CardBox>
</template>

<script setup>
import FileUploadSection from '@/Components/FileUpload.vue';
import { inject } from 'vue';
import CardBox from '@/Components/CardBox.vue';

const form = inject('form')
</script>
