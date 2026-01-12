<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg"
                        class="hover:cursor-pointer data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                        <UserProfile />
                        <BaseIcon :path="mdiUnfoldMoreHorizontal" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>

                <DropdownMenuContent class="w-[--reka-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : 'right'" align="end" :side-offset="4">
                    <DropdownMenuLabel class="p-0 font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <UserProfile />
                        </div>
                    </DropdownMenuLabel>

                    <DropdownMenuSeparator />

                    <template v-for="(section, index) in userMenu" :key="index">
                        <DropdownMenuGroup v-if="!section?.isSeparator">
                            <UserItemProfile v-for="item in section.items" :key="item.route" v-bind="item" />
                        </DropdownMenuGroup>

                        <DropdownMenuSeparator v-else />
                    </template>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>

<script setup>
import BaseIcon from "@/Components/BaseIcon.vue";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/Components/ui/sidebar';

import { mdiUnfoldMoreHorizontal } from "@mdi/js";
import UserProfile from "./UserProfile.vue";
import UserItemProfile from "./UserItemProfile.vue";
import userMenu from "../Composables/userMenu";
import DropdownMenuLabel from "@/Components/ui/dropdown-menu/DropdownMenuLabel.vue";

const { isMobile } = useSidebar();
</script>
