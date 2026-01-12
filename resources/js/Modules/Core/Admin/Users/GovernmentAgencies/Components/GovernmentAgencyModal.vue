<template>
    <Modal :show="modelValue" max-width="xl" :closeable="true" @close="$emit('update:modelValue', false)">
        <div class="group transition-all duration-300 border border-border/50 rounded-xl bg-white relative">
            <BaseButton @click="$emit('update:modelValue', false)" class="absolute top-4 right-4 z-10" :icon="mdiClose"
                color="lightDark" small title="Cerrar" />
            <div class="flex justify-center items-center py-6">
                <div
                    class="w-24 h-24 lg:w-28 lg:h-28 mx-auto rounded-full flex items-center justify-center border-4 border-white bg-white shadow-2xl overflow-hidden">
                    <div class="w-20 h-20 lg:w-24 lg:h-24 rounded-full bg-white flex items-center justify-center">
                        <img :src="agency.logo?.path || IMAGES.ccytem.src" :alt="agency.name || IMAGES.ccytem.alt"
                            loading="lazy" class="object-contain w-full h-full rounded-full" />
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h3 class="my-4 text-forest-400 text-xl lg:text-2xl font-bold">{{ agency.name }}</h3>
                <div class="mb-4 grid grid-cols-2 gap-4 text-forest-900">
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Acrónimo</span>
                        <span class="text-base text-forest-900">{{ agency.acronym || 'Sin acrónimo' }}</span>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Nivel de Gobierno</span>
                        <span class="text-base text-forest-900">{{ agency.government_level?.name || 'Sin nivel'
                            }}</span>
                    </div>
                </div>
                <div class="mb-4 grid grid-cols-2 gap-4 text-forest-900">
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Sector Económico</span>
                        <span class="text-base text-forest-900">{{ agency.government_sector?.name || 'Sin sector'
                            }}</span>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-semibold uppercase text-forest-500">Estado</span>
                        <span class="text-base text-forest-900">{{ agency.is_active ? 'Activo' : 'Inactivo' }}</span>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4 text-forest-900">
                    <div class="flex flex-col items-start col-span-2">
                        <span class="text-xs font-semibold uppercase text-forest-500">Objetivos</span>
                        <span class="text-base text-forest-900">{{ agency.objectives || 'Sin objetivos' }}</span>
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
    agency: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: Boolean,
        required: true,
    },
});
</script>
