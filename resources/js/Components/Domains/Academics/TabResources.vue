<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiImage" size="24" h="h-10" w="w-10" />
                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Recursos
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Fotografía del académico
                    </p>
                </div>
            </div>
        </template>

        <CardSection title="Fotografía" description="Fotografía del académico" :hasDivider="false">
            <div v-if="academic?.photo" class="flex justify-center">
                <img :src="academic.photo.path" :alt="academic.full_name"
                    class="w-48 h-48 object-cover rounded-lg shadow-md" />
            </div>
            <div v-else class="text-center p-8 text-gray-500">
                No hay fotografía disponible.
            </div>
        </CardSection>
    </CardForm>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';
import CardSection from '@/Components/CardSection.vue';
import { mdiImage } from '@mdi/js';
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

const injectData = inject('academic', null);

const academic = computed(() => {
    return props.data || injectData || {};
});
</script>
