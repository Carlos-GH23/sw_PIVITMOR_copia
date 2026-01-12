<template>
    <Modal :show="show" max-width="xl" :closeable="true" @close="$emit('close')">
        <CardBox :hasBorder="false">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <BaseIcon :path="mdiCommentMultiple" class="text-forest-400" />
                        <h2 class="text-forest-400 text-xl font-bold">Evaluaciones</h2>
                    </div>

                    <BaseButton color="light" @click="$emit('close')" :icon="mdiClose" />
                </div>
                <span class="text-sm font-light text-slate-800 dark:text-slate-300">
                    Historial de comentarios de la(s) solicitudes de revisión
                </span>
            </div>

            <AssessmentRecords :assessments="assessments"/>
        </CardBox>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardBox from '@/Components/CardBox.vue';
import Modal from '@/Components/Modal.vue';
import { mdiClose, mdiCommentMultiple } from '@mdi/js';
import AssessmentRecords from '@/Components/AssessmentRecords.vue';

defineProps({
    show: Boolean,
    assessments: Array,
});
</script>
