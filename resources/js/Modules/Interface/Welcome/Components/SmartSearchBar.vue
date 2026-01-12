<template>
    <div class="flex mb-8">
        <div class="relative flex-1">
            <input name="search" type="search" :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)" @search="$emit('search', $event)"
                @keyup.enter="$emit('apply')" :placeholder="placeholder"
                class="w-full text-mono-900 h-12 text-base border-gray-300 rounded-lg rounded-r-none pl-8 border-2 border-wine-50 focus:outline-1 focus:outline-offset-0 focus:outline-wine-50" />
            <BaseIcon :path="mdiMagnify"
                class="absolute left-2 top-1/2 transform -translate-y-1/2 text-wine-400 h-5 w-5" />
        </div>
        <button
            class="cursor-pointer px-8 h-12 bg-wine-50 rounded-lg rounded-l-none hover:opacity-90 text-white text-base transition-opacity focus:outline-1 focus:outline-offset-0 focus:outline-wine-50"
            @click="$emit('apply')">
            Buscar
        </button>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import { mdiMagnify } from '@mdi/js';

const props = defineProps({
    modelValue: String,
    placeholder: {
        type: String,
        default: 'Busca capacidades, necesidades, servicios o empleos...'
    }
});

defineEmits(['update:modelValue', 'search', 'apply']);
</script>

<style scoped>
input[type="search"]::-webkit-search-cancel-button {
    filter: none;
    appearance: none;
    -webkit-appearance: none;
    height: 18px;
    width: 18px;
    background: url('data:image/svg+xml;utf8,<svg fill="%237B112C" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="%237B112C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>') center/18px 18px no-repeat;
    cursor: pointer;
}
</style>
