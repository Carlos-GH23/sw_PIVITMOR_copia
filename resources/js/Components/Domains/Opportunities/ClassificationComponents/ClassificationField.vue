<template>
    <LabelText :label="label">
        <template #default>
            <div class="flex flex-col gap-2 flex-wrap">
                <span v-for="item in items" :key="item.id">
                    {{ getDisplayName(item) }}
                </span>
            </div>
        </template>
    </LabelText>
</template>

<script setup>
import LabelText from '@/Components/LabelText.vue';

defineProps({
    label: {
        type: String,
        required: true
    },
    items: {
        type: Array,
        required: true
    }
});

function getDisplayName(item) {
    return item.name || item.type || item.title || String(item);
}
</script>