<template>
    <CardBox>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg text-forest-400 font-semibold text-balance">{{ title }}</h2>
            <DropdownMenu as-child>
                <DropdownMenuTrigger>
                    <BaseButton :icon="mdiDotsVertical" color="lightDark" />
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-52">
                    <DropdownMenuLabel>
                        <strong>
                            Opciones
                        </strong>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <slot name="actions" />
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
        <slot name="chart" />
        <BaseDivider v-if="hasDivider" />
        <slot name="legend" />
    </CardBox>
</template>
<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import BaseDivider from '@/Components/BaseDivider.vue';
import CardBox from '@/Components/CardBox.vue';
import { mdiDotsVertical } from '@mdi/js';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'

defineProps({
    title: String,
    hasDivider: Boolean
})
</script>