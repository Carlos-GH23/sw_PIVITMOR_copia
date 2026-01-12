<template>
    <Modal :show="show" max-width="xl" :closeable="true">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <FileText class="w-5 h-5 text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">Términos y Condiciones</h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
            </div>
                <div v-html="policies.terms_and_conditions?? 'Aún no hay contenido disponible'" class="prose prose-sm max-w-full prose-forest-500 w-full max-h-120 overflow-y-auto overflow-x-hidden"></div>
        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import CardBox from '@/Components/CardBox.vue';
import Modal from '@/Components/Modal.vue';
import { mdiClose } from '@mdi/js';
import { FileText } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

defineProps({
    show: Boolean
});

const policies = usePage().props.policies?.data || {};

const emit = defineEmits(['close']);
</script>