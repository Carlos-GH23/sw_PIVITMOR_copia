<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiInformation" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Información general
                    </p>
                    <p class=" text-sm font-light text-slate-800 dark:text-slate-300">
                        Datos básicos de la oferta laboral
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Nombre" :text="data.name" />
            <div class="grid md:grid-cols-2 gap-4">
                <LabelText label="Puesto" :text="data.position" />
                <LabelText label="Tipo de oferta" :text="data.job_offer_type?.name" />
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <LabelText label="Grado académico requerido" :text="data.academic_degree?.name" />
                <LabelText label="Género" :text="data.gender" />
            </div>
        </div>

        <CardSection title="Periodo de publicación" description="Periodo de publicación de la oferta laboral">
            <div class="grid md:grid-cols-2 gap-4">
                <LabelText label="Fecha de inicio" :text="data.start_date" />
                <LabelText label="Fecha de fin" :text="data.end_date" />
            </div>
        </CardSection>

        <CardSection title="Detalles de la vacante" description="Datos adicionales de la oferta laboral">
            <div class="space-y-6">
                <LabelText label="Descripción de la vacante" :text="data.job_description" />
                <LabelText label="Responsabilidades" :text="data.responsibilities" />
                <LabelText label="Habilidades e idiomas" :text="data.skills_languages" />
                <LabelText label="Observaciones" :text="data.observations" />
                <LabelText label="Comentarios" :text="data.comments" />
            </div>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiInformation } from '@mdi/js';

defineProps({
    hasBorder: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        required: false,
    },
});
</script>
