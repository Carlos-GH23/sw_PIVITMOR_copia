<template>
    <div class="bg-white px-4 pt-4 pb-2 flex items-center relative">
        <textarea v-model="message" @keydown.enter.prevent="sendMessage" placeholder="Escribe tu pregunta..."
            class="flex-1 min-h-20 max-h-40 border border-wine-50 resize-none rounded-lg pl-4 pr-10 py-2 border-wine-50 focus:outline-1 focus:outline-offset-0 focus:outline-wine-50" />
        <button :disabled="isLoading || isEmpty" @click="sendMessage"
            :class="{ 'opacity-50 cursor-not-allowed': isLoading || isEmpty, 'hover:opacity-90 hover:cursor-pointer': !isLoading && !isEmpty }"
            class="absolute right-7 top-1/2 transform -translate-y-1/2 bg-wine-100 text-white rounded-full p-2 ml-2 focus:outline-none transition-colors">
            <SendHorizonal v-if="!isLoading" class="w-5 h-5" />
            <Loader v-else class="w-5 h-5 animate-spin" />
        </button>
    </div>
</template>

<script setup lang="ts">
import { SendHorizonal, Loader } from 'lucide-vue-next';
import { ref, computed } from 'vue';

interface props {
    isLoading: boolean
}

const props = defineProps<props>();

const emits = defineEmits<{
    sendMessage: [text: string]
}>();

const message = ref<string>('');

const isEmpty = computed(() => message.value.trim() === '');

const sendMessage = () => {
    if (props.isLoading) return;
    if (!message.value) return;

    if (isEmpty.value) return;
    emits('sendMessage', message.value);
    message.value = '';
};

</script>