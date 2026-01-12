<template>
    <CardForm v-if="technologyService">
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
            <LabelText label="Título" :text="technologyService.title" />
            <LabelText label="Descripción" :text="technologyService.technical_description" />
            <LabelText label="Departamento" :text="technologyService.department?.name" />
            <LabelText v-if="technologyService?.service_type" label="Tipo de servicio"
                :text="technologyService.service_type?.name" />
            <LabelText v-if="technologyService?.service_category" label="Categoría de servicio"
                :text="technologyService.service_category?.name" />

            <LabelText label="Palabras clave" v-if="technologyService.keywords?.length > 0">
                <template #default>
                    <div class="flex gap-2 flex-wrap">
                        <Badge variant="solid" color="forest" v-for="keyword in technologyService.keywords"
                            :key="keyword.id">
                            {{ keyword.name }}
                        </Badge>
                    </div>
                </template>
            </LabelText>
        </div>
    </CardForm>
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import LabelText from '@/Components/LabelText.vue';
import { mdiInformation } from '@mdi/js';
import { inject } from 'vue';

const technologyService = inject('technologyService');
</script>
