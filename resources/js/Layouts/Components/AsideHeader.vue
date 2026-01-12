<template>
    <SidebarHeader>
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton size="lg"
                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                    <div class="flex aspect-square  items-center justify-center">
                        <img class="rounded transition-all ease-in-out"
                            :class="state === 'collapsed' ? 'size-8' : 'size-12'" :src="logo" alt="logo-pivitmor" />
                    </div>
                    <div v-if="state !== 'collapsed'" class="grid flex-1 text-left text-sm leading-tight">
                        <span class="truncate font-semibold">Panel de control</span>
                        <span class="truncate text-xs">Barra de navegación</span>
                    </div>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarHeader>
</template>

<script setup>
import { SidebarHeader } from '@/Components/ui/sidebar';
import SidebarMenu from "@/Components/ui/sidebar/SidebarMenu.vue";
import SidebarMenuItem from "@/Components/ui/sidebar/SidebarMenuItem.vue";
import SidebarMenuButton from "@/Components/ui/sidebar/SidebarMenuButton.vue";
import { useSidebar } from "@/Components/ui/sidebar/utils";

const { state } = useSidebar();
defineProps({
    logo: String,
});
</script>