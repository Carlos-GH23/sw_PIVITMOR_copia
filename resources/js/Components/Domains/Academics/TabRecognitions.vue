<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiTrophy" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Reconocimientos
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Capacidades, servicios y conferencias del académico
                    </p>
                </div>
            </div>
        </template>

        <div class="space-y-6">
            <CardSection title="Certificaciones académicas" description="Certificaciones académicas obtenidas"
                :hasDivider="false">
                <AcademicCertificationRecords :academicCertifications="academic.academic_certifications" />
            </CardSection>

            <CardSection title="SNII - SICIHTI" description="Sistema Nacional de Investigadores e Investigadoras">
                <div v-if="academic.sni_membership">
                    <div class="grid md:grid-cols-3 gap-4 mb-5">
                        <LabelText label="Número de CVU" :text="academic.sni_membership?.number" />
                        <LabelText label="Nivel" :text="academic.sni_membership?.sni_level?.name" />
                        <LabelText label="Área" :text="academic.sni_membership?.research_area?.name" />
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <LabelText label="Fecha de inicio" :text="academic.sni_membership?.start_date" />
                        <LabelText label="Fecha de fin" :text="academic.sni_membership?.end_date" />
                    </div>
                </div>
                <CardBoxComponentEmpty v-else />
            </CardSection>

            <CardSection title="PRODEP" description="Programa para el Desarrollo Profesional Docente">
                <div v-if="academic.desirable_profile" class="grid md:grid-cols-2 gap-4">
                    <LabelText label="Fecha de inicio" :text="academic.desirable_profile?.start_date" />
                    <LabelText label="Fecha de fin" :text="academic.desirable_profile?.end_date" />
                </div>

                <CardBoxComponentEmpty v-else />
            </CardSection>
        </div>
    </CardForm>
</template>

<script setup>
import AcademicCertificationRecords from './AcademicCertificationRecords.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiTrophy } from '@mdi/js';
import { computed, inject } from 'vue';

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

const injectData = inject('academic', null);

const academic = computed(() => {
    return props.data || injectData || {};
});
</script>