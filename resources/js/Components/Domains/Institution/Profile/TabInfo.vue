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
                        Datos básicos de la institución
                    </p>
                </div>
            </div>
        </template>

        <div class="flex flex-col md:items-center md:flex-row gap-4">
            <ImageFrame :src="data.logo?.path" />

            <div class="flex flex-col col-span-2 space-y-4">
                <h3 class="text-lg font-semibold text-foreground mb-2">{{ data.name }}</h3>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">RENIIECYT:
                        <span class="text-foreground font-light">
                            {{ data.reniecyt?.register_number || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Categoría:
                        <span class="text-foreground font-light">
                            {{ data.institution_type?.institution_category?.name || 'Sin datos' }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Tipo de institución:
                        <span class="text-foreground font-light">{{ data.institution_type?.name || 'Sin datos' }}</span>
                    </label>
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-md font-medium text-forest-400">Ubicación:
                        <span class="text-foreground font-light">
                            {{ data.location?.full_address || 'Sin datos' }}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <LabelText label="Descripción" :text="data.description" />
    </CardForm>
</template>

<script setup>
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
