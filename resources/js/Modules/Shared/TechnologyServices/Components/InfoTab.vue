<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div class="space-y-">
                    <p class="text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Proporciona los datos básicos del servicio tecnológico
                    </p>
                </div>
            </div>
        </template>

        <div class="grid md:grid-cols-1 gap-4 mb-4">
            <FormField label="Título" required :error="form.errors.title">
                <FormControl v-model="form.title" type="textarea" maxLength="255"
                    placeholder="Ejemplo: Sistema inteligente de monitoreo ambiental para invernaderos." />
            </FormField>

            <FormField label="Descripción técnica" :error="form.errors.technical_description">
                <FormControl v-model="form.technical_description" type="textarea" height="h-48" maxLength="2000"
                    placeholder="Describa en qué consiste la tecnología, cómo funciona y sus características principales. 
Ejemplo: Software basado en inteligencia artificial que analiza imágenes médicas en tiempo real para apoyar diagnósticos tempranos de cáncer, reduciendo tiempos y errores clínicos." />
            </FormField>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <FormField label="Categoría del servicio" required :error="form.errors.technology_service_category_id">
                <FormControl v-model="form.technology_service_category_id" :options="serviceCategories"
                    option-label="name" option-value="id" placeholder="Seleccione una categoría de servicio" />
            </FormField>

            <FormField label="Tipo de servicio" required :error="form.errors.technology_service_type_id">
                <FormControl v-model="form.technology_service_type_id" :options="filteredServiceTypes"
                    option-label="name" option-value="id" :disabled="!form.technology_service_category_id"
                    :placeholder="form.technology_service_category_id ? 'Seleccione un tipo de servicio' : 'Primero seleccione una categoría'" />
            </FormField>

            <FormField label="Palabras clave" :error="form.errors.keywords">
                <KeywordInput v-model="form.keywords" :limit="5" />
            </FormField>
        </div>

        <CardSection title="Periodo de publicación" description="Periodo de publicación del servicio tecnológico"
            :icon="mdiCalendarBlankOutline">
            <div class="grid grid-cols-2 gap-4">
                <FormField label="Fecha de inicio" :error="form.errors.start_date" required>
                    <FormControl v-model="form.start_date" type="date" />
                </FormField>

                <FormField label="Fecha de cierre" :error="form.errors.end_date">
                    <FormControl v-model="form.end_date" type="date" />
                </FormField>
            </div>
        </CardSection>

        <CardSection title="Imágenes relacionadas" description="Agrega imágenes relacionadas con la oferta tecnológica"
            iconClasses="bg-forest-400 text-mono-100 rounded-lg" :icon="mdiImageOutline">
            <FormField help="Máximo 5 imágenes por publicación" :error="form.errors.photos">
                <ImageUploadCarousel :form="form" />
            </FormField>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FormField from '@/Components/FormField.vue';
import FormControl from '@/Components/FormControl.vue';
import KeywordInput from '@/Components/KeywordInput.vue';
import { mdiCalendarBlankOutline, mdiInformation, mdiImageOutline } from '@mdi/js';
import { inject, computed, watch } from 'vue';
import ImageUploadCarousel from '@/Components/ImageUploadCarousel.vue';

const form = inject('form');
const serviceTypes = inject('serviceTypes', []);
const serviceCategories = inject('serviceCategories', []);

const filteredServiceTypes = computed(() => {
    if (!form.technology_service_category_id) {
        return;
    }
    return serviceTypes.filter(type => type.category_id === form.technology_service_category_id);
});

watch(() => form.technology_service_category_id, (newCategoryId, oldCategoryId) => {
    if (newCategoryId !== oldCategoryId && form.technology_service_type_id) {
        const currentTypeValid = filteredServiceTypes.value.some(
            type => type.id === form.technology_service_type_id
        );
        if (!currentTypeValid) {
            form.technology_service_type_id = null;
        }
    }
});

</script>