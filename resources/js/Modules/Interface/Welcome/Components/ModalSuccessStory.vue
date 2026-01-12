<template>
    <Modal :show="props.show" :closeable="true" @close="closeModal" maxWidth="2xl">
        <CardSuccessStory :successStory="successStory">
            <template #comments>
                <div v-html="successStory.story" class="text-sm text-mono-400 ql-content leading-relaxed mt-1"></div>
            </template>
        </CardSuccessStory>

        <div class="flex justify-end">
            <button @click="closeModal" as="button"
                class="w-full py-2 text-white hover:cursor-pointer hover:opacity-90 transition-all bg-wine-400">
                Cerrar
            </button>
        </div>
    </Modal>
</template>
<script setup>
import Modal from '@/Components/Modal.vue';
import CardSuccessStory from './CardSuccessStory.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    successStory: {
        type: Object,
        default: () => ({})
    },
});

const emit = defineEmits(['close']);
const closeModal = () => emit('close');
</script>