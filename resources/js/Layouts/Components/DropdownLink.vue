<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    routeName: {
        type: String,
        default: ''
    },
    label: {
        type: String,
        default: ''
    },
    as: {
        type: [String, Object],
        default: null
    },
});

const is = computed(() => props.as || Link);

const componentProps = computed(() => {
    const attrs = {};

    if (props.routeName && props.routeName.trim() !== '') {
        attrs.href = route(props.routeName);
    }

    return attrs;
});
</script>

<template>
    <component :is="is" v-bind="componentProps"
        class="transition-all w-full text-left text-forest-100 block p-2 group relative rounded hover:text-earth-50 hover:bg-forest-300 xl:text-white hover:cursor-pointer 
        xl:bg-forest-100 xl:p-2 xl:border-0 xl:hover:bg-forest-50 xl:hover:text-mono-100 xl:first:rounded-b-none xl:last:rounded-t-none ">
        {{ label }}
    </component>
</template>