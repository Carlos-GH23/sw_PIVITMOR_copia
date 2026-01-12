<template>
    <div class="">
        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <BaseIcon :path="icon" size="20" h="h-auto" w="w-auto" class="p-2 rounded-full bg-wine-100 text-white" />
            {{ title }}
        </h3>
        <div class="space-y-2">
            <div v-if="selectedItems.length > 0" v-for="item in selectedItems" :key="item.id"
                class="flex items-center justify-between bg-blue-50 dark:bg-slate-950 rounded-lg px-3 py-2">
                <span class="text-slate-800 dark:text-slate-200">
                    {{ item.name }}
                </span>
                <!-- <BaseButton :icon="mdiClose" color="lightDark" @click="removeItem(i)" /> -->
            </div>
            <CardBoxComponentEmpty v-else />
        </div>
    </div>
</template>
<script setup>
import { mdiFormatListBulleted } from '@mdi/js'
import { onMounted, ref } from 'vue'
import BaseIcon from '@/Components/BaseIcon.vue'
import CardBoxComponentEmpty from '@/Components/CardBoxComponentEmpty.vue'

const props = defineProps({
    icon: {
        type: String,
        default: mdiFormatListBulleted,
    },
    title: {
        type: String,
        required: true,
    },
    values: {
        type: Array,
        required: true,
    },
    itemsKey: { type: String, default: 'items' },
    items: {
        type: Array,
        default: () => [],
    },
})

const selectedItems = ref([]);

onMounted(() => {
    if (props.values.length === 0) return;
    const selectedIds = new Set(props.values);

    selectedItems.value = props.items
        .filter(category => category[props.itemsKey]?.length > 0)
        .flatMap(category => category[props.itemsKey])
        .filter(item => selectedIds.has(item.id));
});

</script>