<template>
    <LabelText v-if="hasValue" :label="field.label">
        <template #default>
            <div v-if="field.component === 'badge-list'" class="flex gap-2 flex-wrap">
                <Badge variant="solid" color="forest" v-for="item in items" :key="item.id">
                    {{ item.name }}
                </Badge>
            </div>

            <span v-else>{{ value }}</span>
        </template>
    </LabelText>
</template>

<script setup>
import Badge from '@/Components/Badge.vue';
import LabelText from '@/Components/LabelText.vue';
import { computed } from 'vue';
import { getFieldValue } from '@/Configs/opportunityInfoConfig';

const props = defineProps({
    field: {
        type: Object,
        required: true
    },
    opportunity: {
        type: Object,
        required: true
    }
});

const value = computed(() => {
    return getFieldValue(props.opportunity, props.field.path || props.field.key);
});

const items = computed(() => {
    if (props.field.component === 'badge-list') {
        return props.opportunity[props.field.key] || [];
    }
    return [];
});

const hasValue = computed(() => {
    if (props.field.component === 'badge-list') {
        return items.value.length > 0;
    }
    return value.value != null;
});
</script>