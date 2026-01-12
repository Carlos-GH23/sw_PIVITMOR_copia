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
                        Ponentes y archivos relacionados
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Ponentes" description="Académicos que participan como ponentes en esta conferencia"
            :hasDivider="false">
            <AcademicRecords :academics="conference.academics" />
        </CardSection>

        <CardSection title="Archivos relacionados" description="Documentos y archivos de la conferencia">
            <FilesTable :files="conference.files" />
        </CardSection>
    </CardForm>
</template>

<script setup>
import AcademicRecords from '@/Components/Domains/Academics/AcademicRecords.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';
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

const injectData = inject('conference', null);

const conference = computed(() => {
    return props.data || injectData || {};
});
</script>
