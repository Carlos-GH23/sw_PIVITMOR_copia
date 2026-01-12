<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiFileDocument" size="24" h="h-10"
                    w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Recursos
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Académicos, líneas de investigación y archivos
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Académicos participantes" description="Académicos que forman parte de este cuerpo académico"
            :hasDivider="false">
            <AcademicRecords :academics="academicBody.academics" />
        </CardSection>

        <CardSection title="Líneas de investigación" description="Líneas de investigación del cuerpo académico">
            <ResearchLineRecords :researchLines="academicBody.research_lines" />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Documentos y archivos del cuerpo académico">
            <FilesTable :files="academicBody.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';
import AcademicRecords from '@/Components/Domains/Academics/AcademicRecords.vue';
import ResearchLineRecords from '../ResearchLines/ResearchLineRecords.vue';
import { mdiFileDocument } from '@mdi/js';
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

const injectData = inject('academic_body', null);

const academicBody = computed(() => {
    return props.data || injectData || {};
});
</script>
