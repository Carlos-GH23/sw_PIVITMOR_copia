<template>
    <Collapsible v-if="verifyPermission(permission)" asChild v-model:open="isOpen" class="group/collapsible">
        <SidebarMenuItem>
            <CollapsibleTrigger asChild>
                <SidebarMenuButton :tooltip="label" class="hover:cursor-pointer">
                    <BaseIcon v-if="icon" :path="icon" />
                    <span>{{ label }}</span>
                    <ChevronRight
                        class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />

                </SidebarMenuButton>
            </CollapsibleTrigger>
        </SidebarMenuItem>

        <CollapsibleContent>
            <SidebarMenuSub v-for="item in filteredMenu" :key="item.label">
                <SidebarMenuSubItem>
                    <SidebarMenuSubButton :isActive="activeRoute(item.route)" asChild>
                        <Link :href="route(item.route)" class="flex items-center gap-2">
                        <BaseIcon :path="item.icon" />
                        <span class="text-sm">{{ item.label }}</span>
                        </Link>
                    </SidebarMenuSubButton>
                </SidebarMenuSubItem>
            </SidebarMenuSub>
        </CollapsibleContent>
    </Collapsible>
</template>

<script setup>
import BaseIcon from '@/Components/BaseIcon.vue';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger
} from '@/Components/ui/collapsible';
import {
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem
} from '@/Components/ui/sidebar';
import { mdiChevronRight } from '@mdi/js';
import { Link } from '@inertiajs/vue3';
import { verifyPermission } from "@/Hooks/usePermissions.js";
import { computed, inject, onMounted, ref } from 'vue';
import { ChevronRight } from 'lucide-vue-next';

const { menu } = defineProps({
    label: String,
    permission: String,
    icon: String,
    menu: Array
});

const activeRoute = inject("activeRoute");
const isOpen = ref(false);

const filteredMenu = computed(() =>
    menu?.filter(item => verifyPermission(item.permission)) || []
);

onMounted(() => {
    const routeCurrent = route().current();
    const someActive = filteredMenu.value.some((item) => item.route === routeCurrent);
    if (someActive) {
        isOpen.value = true;
    }
})
</script>