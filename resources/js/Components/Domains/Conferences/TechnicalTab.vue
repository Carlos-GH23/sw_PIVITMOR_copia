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
                        Datos básicos del servicio tecnológico
                    </p>
                </div>
            </div>
        </template>
        <div class="space-y-6">
            <LabelText label="Requerimentos técnicos" :text="conference.technical_requirements" />
            <CardSection title="Archivos relacionados" description="Archivos relacionados con los requerimientos técnicos">
                <FilesTable :files="conference?.files" />
            </CardSection>
        </div>
    </CardForm>
</template>
<script setup>
import LabelText from '@/Components/LabelText.vue';
import { inject } from 'vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import CardForm from '@/Components/CardForm.vue';
import { mdiInformation } from '@mdi/js';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardSection from '@/Components/CardSection.vue';
import FilesTable from '@/Components/FilesTable.vue';

defineProps({
    hasBorder: Boolean,
})

const conference = inject('conference')
</script>