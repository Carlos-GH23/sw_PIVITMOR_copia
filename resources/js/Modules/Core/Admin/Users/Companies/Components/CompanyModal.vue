<template>
    <Modal :show="modelValue" max-width="xl" :closeable="true" @close="$emit('update:modelValue', false)">
        <div class="group transition-all duration-300 border border-border/50 rounded-xl bg-white">
            <BaseButton @click="$emit('update:modelValue', false)" class="absolute top-4 right-4 z-10" :icon="mdiClose"
                color="lightDark" small title="Cerrar" />
            <div class="flex justify-center items-center py-6">
                <div
                    class="w-24 h-24 lg:w-28 lg:h-28 mx-auto rounded-full flex items-center justify-center border-4 border-white bg-white shadow-2xl overflow-hidden">
                    <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-white flex items-center justify-center">
                        <img :src="(company.logo && company.logo.path) ? company.logo.path : IMAGES.user.src"
                            :alt="company.name || IMAGES.user.alt" loading="lazy"
                            class="object-contain w-full h-full rounded-full" />
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="my-4 text-forest-400 text-xl lg:text-2xl font-bold">{{ company.name }}</h3>
                <div class="mb-4 grid grid-cols-2 gap-4 text-forest-900">
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Razón Social</span>
                        <span class="text-base text-forest-900">{{ company.legal_name || 'Sin razón social' }}</span>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">RFC</span>
                        <span class="text-base text-forest-900">{{ company.rfc || 'Sin RFC' }}</span>
                    </div>
                </div>
                <div class="mb-4 grid grid-cols-2 gap-4 text-forest-900">
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Año de Fundación</span>
                        <span class="text-base text-forest-900">{{ company.year || 'Sin año' }}</span>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Estado</span>
                        <span class="text-base text-forest-900">{{ company.is_active ? 'Activa' : 'Inactiva' }}</span>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4 text-forest-900">
                    <div class="flex flex-col items-start col-span-2">
                        <span class="text-xs font-semibold uppercase text-forest-500">Misión</span>
                        <span class="text-base text-forest-900" v-html="company.mission || 'Sin misión'" />
                    </div>
                    <div class="flex flex-col items-start col-span-2">
                        <span class="text-xs font-semibold uppercase text-forest-500">Visión</span>
                        <span class="text-base text-forest-900" v-html="company.vision || 'Sin visión'" />
                    </div>
                    <div class="flex flex-col items-start col-span-2">
                        <span class="text-xs font-semibold uppercase text-forest-500">Descripción</span>
                        <span class="text-base text-forest-900" v-html="company.overview || 'Sin descripción'" />
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import { IMAGES } from '@/Utils/Image';
import Modal from '@/Components/Modal.vue';
import BaseButton from '@/Components/BaseButton.vue';
import { mdiClose } from '@mdi/js';
const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: Boolean,
        required: true,
    },
});
</script>
