<template>
    <CardForm>
        <template #header>
            <div class="flex gap-2 items-center py-4">
                <BaseIcon class="bg-forest-400 text-mono-100 rounded-lg" :path="mdiImageMultiple" size="24" h="h-10"
                    w="w-10" />

                <div>
                    <p class="text-forest-400 text-xl font-bold">
                        Imágenes
                    </p>
                    <p class="text-sm font-light text-slate-800 dark:text-slate-300">
                        Imágenes relacionadas con la necesidad tecnológica
                    </p>
                </div>
            </div>
        </template>
        <ImageSwiper :photos="requirement.photos" :slides="2" showEmpty>
            <template #actions="{ photo }">
                <BaseButton :icon="mdiOpenInNew" :href="photo.path" target="_blank" />
            </template>
        </ImageSwiper>
    </CardForm>
</template>
<script setup>
import { mdiImageMultiple, mdiOpenInNew } from '@mdi/js';
import { computed, inject, unref } from 'vue';
import BaseButton from '@/Components/BaseButton.vue';
import ImageSwiper from '@/Components/ImageSwiper.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import CardForm from '@/Components/CardForm.vue';

const props = defineProps({
    data: {
        type: Object,
        required: false,
    },
});

const injectData = inject('requirement', null);

const requirement = computed(() => {
    return props.data || unref(injectData) || {};
});

</script>