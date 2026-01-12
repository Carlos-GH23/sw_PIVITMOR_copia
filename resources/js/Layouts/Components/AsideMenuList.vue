<template>
    <SidebarMenu>
        <AsideCollapsibleItem v-if="item?.menu" v-bind="item" />

        <SidebarMenuItem v-else-if="verifyPermission(item?.permission)">
            <SidebarMenuButton :tooltip="item.label" :isActive="activeRoute(item.route)" asChild>
                <Link :href="route(item.route)">
                <BaseIcon :path="item.icon" />
                <span class="text-sm">{{ item.label }}</span>
                </Link>
            </SidebarMenuButton>
        </SidebarMenuItem>
    </SidebarMenu>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import { SidebarMenu, SidebarMenuItem, SidebarMenuButton } from '@/Components/ui/sidebar';
import AsideCollapsibleItem from './AsideCollapsibleItem.vue';

import { Link } from '@inertiajs/vue3';
import { verifyPermission } from '@/Hooks/usePermissions';
import { provide } from 'vue';

defineProps({
    item: {
        type: Object,
        required: true
    }
});

const activeRoute = (routeName) => {
    return route().current(routeName);
};

provide("activeRoute", activeRoute);
</script>