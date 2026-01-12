<template>
    <DropdownMenuItem as-child>
        <Link as="button" class="flex items-center cursor-pointer w-full" :method="method" :href="route(routeName)">
        <BaseIcon :path="icon" />
        {{ label }}
        </Link>
    </DropdownMenuItem>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import {
    DropdownMenuItem,
} from '@/Components/ui/dropdown-menu';
import { Link } from '@inertiajs/vue3';

defineProps({
    icon: String,
    label: String,
    method: String,
    routeName: String,
});
</script>