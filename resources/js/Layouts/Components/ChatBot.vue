<template>
    <transition enter-active-class="transition duration-300 ease-out"
        enter-from-class="transform translate-x-10 opacity-0" enter-to-class="transform translate-x-0 opacity-100"
        leave-active-class="transition duration-300 ease-in" leave-from-class="transform translate-x-0 opacity-100"
        leave-to-class="transform translate-x-10 opacity-0">
        <div v-if="showChat"
            class="fixed z-50 bottom-0 md:bottom-2 md:right-2  ring-wine-50 ring-1 md:rounded bg-white overflow-hidden">
            <div class="flex flex-col w-screen h-screen md:w-96 md:h-[600px] overflow-y-auto">
                <div class="flex justify-between items-center bg-wine-50 p-4">
                    <span class="text-lg text-mono-100 font-bold">Pivitmor</span>
                    <BaseIcon @click="closeChat"
                        class="text-white hover:bg-white hover:text-wine-50 rounded-sm hover:cursor-pointer transition-colors"
                        :path="mdiClose" />
                </div>

                <InitialMessage v-if="messages.length === 0" />

                <ChatMessages :messages="messages" :isLoading="isLoading" />

                <MessageBox @send-message="onMessage" :isLoading="isLoading" />

                <span class="text-xs text-center text-gray-500 mb-4">
                    El asistente virtual puede producir información inexacta
                </span>
            </div>
        </div>
    </transition>

    <div class="fixed z-10 right-2 bottom-2">
        <button @click="$emit('openChat')"
            class="bg-wine-50 rounded-full text-white text-md px-4 py-2 hover:cursor-pointer hover:bg-wine-400 hover:text-gray-50 transition-all duration-150 ease-in-out"
            :class="{ 'translate-x-40': showChat }">
            Asistente virtual
        </button>
    </div>
</template>

<script setup lang="ts">
import BaseIcon from '@/Components/BaseIcon.vue';
import ChatMessages from './Chat/ChatMessages.vue';
import InitialMessage from './Chat/InitialMessage.vue';
import MessageBox from './Chat/MessageBox.vue';
import { useChat } from '../Composables/useChat';
import { mdiClose } from '@mdi/js';
import { onMounted, onUnmounted } from 'vue';

interface props {
    showChat: boolean
}

const props = defineProps<props>();

const emits = defineEmits<{
    closeChat: [],
    openChat: []
}>();

const closeChat = () => {
    emits('closeChat');
};

const { messages, onMessage, isLoading } = useChat();

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.showChat) {
        closeChat();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    // document.body.style.overflow = null;
});
</script>
