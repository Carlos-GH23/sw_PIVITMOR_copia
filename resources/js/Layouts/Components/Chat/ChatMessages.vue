<template>
    <div ref="chatRef" class="flex-1 overflow-y-auto p-4">
        <div class="flex flex-col space-y-2">
            <ChatBubble v-for="(message, index) in messages" :key="message.id" v-bind="message"
                :is-last="index === messages.length - 1" :is-loading="isLoading" />
        </div>
    </div>
</template>

<script setup lang="ts">
import ChatBubble from './ChatBubble.vue';
import type { ChatMessage } from '../../Interfaces/chat-message.interface';
import { nextTick, onMounted, ref, watch } from 'vue';

interface Props {
    messages: ChatMessage[];
    isLoading: boolean;
}

const props = defineProps<Props>();

const chatRef = ref<HTMLDivElement | null>(null);

const scrollToBottom = () => {
    if (!chatRef.value) return;

    chatRef.value.scrollTo({
        top: chatRef.value.scrollHeight,
        behavior: props.isLoading ? 'auto' : 'smooth'
    });
};

watch(() => props.messages, async () => {
    await nextTick();
    scrollToBottom();
}, { deep: true });

onMounted(() => {
    scrollToBottom();
});
</script>