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
                        Datos básicos de la oferta académica
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <LabelText label="Nombre del programa" :text="data.name" />
            <LabelText label="Reseña" :text="data.description" />
            <LabelText label="Objetivo" :text="data.objective" />
            <LabelText label="Perfil de egreso" :text="data.graduate_profile" />
            <LabelText label="Palabras clave">
                <BadgeList :items="data.keywords" />
            </LabelText>
        </div>

        <CardSection title="Información académica" description="Detalles de la oferta académica">
            <div class="space-y-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Nivel educativo" :text="data.educational_level?.name" />
                    <LabelText label="Modalidad de estudio" :text="data.study_mode?.name" />
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Duración (meses)" :text="data.duration_months" />
                    <LabelText label="Costo por semestre" :text="data.semester_cost" />
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Sitio web" :text="data.website" />
                    <LabelText label="Departamento" :text="data.department?.name" />
                </div>

                <LabelText label="REVOE" :text="data.revoe" />
            </div>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BadgeList from '@/Components/BadgeList.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiInformation } from '@mdi/js';

const props = defineProps({
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
