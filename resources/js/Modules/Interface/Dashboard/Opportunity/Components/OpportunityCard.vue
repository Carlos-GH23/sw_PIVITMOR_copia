<template>
    <div
        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-forest-100/50 transform hover:-translate-y-1 w-full flex flex-col">
        <div class="relative w-full h-36 sm:h-44 md:h-48 lg:h-52 overflow-hidden rounded-t-2xl">
            <template v-if="item.photo">
                <img :src="item.photo" alt="image" loading="lazy"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                <div
                    class="absolute inset-0  from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
            </template>

            <Badge class="absolute top-3 left-3" :color="resourceColor[item.resource_type]" variant="solid">
                {{ resourceType[item.resource_type] }}
            </Badge>
        </div>

        <div class="flex-1 p-4 flex flex-col">
            <MatchRecordsTags v-if="item.matches" :records="item.matches" :max-visible="3" />
            <h3 class="text-lg sm:text-xl font-bold text-earth-400 mb-2 sm:mb-3 leading-tight line-clamp-2">
                {{ item.title }}
            </h3>

            <button @click="$emit('openDetails', item)"
                class="group mt-auto w-full bg-forest-400 hover:bg-forest-100 text-sand-50 font-semibold py-2.5 sm:py-3 px-4 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-forest-100/25 hover:text-white cursor-pointer">
                <span>Más información</span>
                <BaseIcon :path="mdiChevronRight" size="22" h="h-auto" w="w-auto"
                    class="transition-transform duration-200 group-hover:translate-x-2" />
            </button>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import Badge from '@/Components/Badge.vue';
import MatchRecordsTags from './MatchRecordsTags.vue';
import { resourceType, resourceColor } from '@/Utils/resources.js';
import { mdiChevronRight } from '@mdi/js';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

defineEmits(['openDetails']);
</script>
