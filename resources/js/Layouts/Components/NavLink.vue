<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
        default: ''
    },
    routeName: {
        type: String,
        default: ''
    },
    as: {
        type: [String, Object],
        default: null
    },
    active: {
        type: Boolean,
        default: null
    }, 
    label: {
        type: String,
        default: 'Link',
    }
});

const is = computed(() => props.as || Link);

const componentProps = computed(() => {
    const attrs = {};

    if (props.routeName) {
        attrs.href = route(props.routeName);
    }
    else if (props.href && props.href.trim() !== '') {
        attrs.href = props.href;
    }

    return attrs;
});

const classes = computed(() => {
    const base = ['transition-all duration-200 ease-in-out block p-2 group rounded-lg relative hover:bg-forest-300 hover:text-earth-50 xl:hover:bg-transparent'];

    if (props.active || route().current(props.routeName)) {
        base.push('font-bold text-earth-100 xl:underline xl:decoration-2 xl:underline-offset-8 xl:decoration-earth-200');
    } else {
        base.push('text-forest-100 xl:text-sand-100 xl:hover:decoration-2 xl:hover:underline xl:hover:underline-offset-8 xl:rounded-lg xl:border-0 xl:hover:text-earth-100');
    }

    return base;
});

</script>

<template>
    <component :is="is" v-bind="componentProps" :class="classes">
        {{ label }}
    </component>
</template>
