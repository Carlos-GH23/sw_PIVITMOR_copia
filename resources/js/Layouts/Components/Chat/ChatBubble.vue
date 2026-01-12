<template>
    <div v-if="itsMine" class="flex justify-end">
        <div class="bg-wine-50 text-white text-sm p-2 rounded-lg max-w-xs">
            <span class="capitalize">{{ message }}</span>
        </div>
    </div>

    <div v-else class="flex flex-col gap-2">
        <div class="flex items-center gap-2">
            <BaseIcon :path="mdiRobot" />
            <span class="text-sm text-gray-500">Asistente virtual</span>
        </div>

        <div class="text-sm p-3 rounded-lg max-w-xs rounded-tl-none shadow-sm transition-colors min-h-[40px] flex items-center"
            :class="[
                isError ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-gray-100 text-gray-800'
            ]">
            <span v-if="isLoading && !message && !isError" class="dot-animated text-gray-500 italic">
                Pensando
            </span>

            <div v-else class="uppercase">
                {{ message }}
                <span v-if="isLoading && isLast && !isError"
                    class="inline-block w-1.5 h-4 align-middle bg-gray-400 animate-pulse ml-0.5"></span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiRobot } from '@mdi/js';

interface Props {
    message: string;
    itsMine: boolean;
    isError: boolean;
    isLoading: boolean;
    isLast: boolean;
}

defineProps<Props>();

</script>


<style scoped>
.dot-animated::after {
    content: '.';
    animation: dots 1.0s steps(5, end) infinite;
    display: inline-block;
    vertical-align: bottom;
    width: 1.25em;
    text-align: left;
}

@keyframes dots {

    0%,
    20% {
        content: '.';
    }

    40% {
        content: '..';
    }

    60% {
        content: '...';
    }

    80%,
    100% {
        content: '';
    }
}
</style>
