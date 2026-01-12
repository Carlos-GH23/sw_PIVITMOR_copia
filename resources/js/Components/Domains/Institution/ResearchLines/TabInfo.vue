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
                        Datos básicos de la línea de investigación
                    </p>
                </div>
            </div>
        </template>

        <div class="flex flex-col md:items-center md:flex-row gap-4">
            <ImageFrame :src="data.logo?.path" alt="Logo de la línea de investigación" type="image" />

            <div class="space-y-6">
                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Nombre:
                        <span class="text-foreground font-light">
                            {{ data.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Departamento:
                        <span class="text-foreground font-light">
                            {{ data.department?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <LabelText label="Descripción" :text="data.description" />
            <LabelText label="Tópicos de investigación">
                <template #default>
                    <BadgeList :items="data.keywords" />
                </template>
            </LabelText>
        </div>
    </CardForm>
</template>

<script setup>
import BadgeList from '@/Components/BadgeList.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import ImageFrame from '@/Components/ImageFrame.vue';
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