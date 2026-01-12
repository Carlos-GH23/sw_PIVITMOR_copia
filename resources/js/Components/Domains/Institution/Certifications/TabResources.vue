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
                        Archivos relacionados con la certificación
                    </p>
                </div>
            </div>
        </template>

        <FilesTable :files="certification?.files" />
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
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

const injectData = inject('certification', null);

const certification = computed(() => {
    return props.data || injectData || {};
});
</script>
