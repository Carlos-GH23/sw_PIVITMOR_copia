<template>
    <div @keyup.esc="close" class="relative" ref="target">
        <div class="relative">
            <button @click="toggle" type="button"
                class="w-full px-4 py-3 pr-10 border bg-forest-400 border-earth-150 rounded-md focus:outline-none focus:ring-2 focus:ring-earth-200 focus:border-earth-200 transition-colors text-left cursor-pointer hover:border-earth-200"
                :class="!selectedItem ? 'text-earth-150/70' : 'text-sand-50'">
                {{ selectedItem ? selectedItem.name : placeholder }}
            </button>
            <div class="absolute right-3 top-3.5 cursor-pointer" @click.stop="toggle">
                <svg :class="['h-4 w-4 text-earth-150 transition-transform', isOpen ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <button v-if="modelValue" @click.stop="clearSelection" type="button" title="Limpiar selección"
                class="absolute right-9 top-3.5 text-earth-150 hover:text-sand-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div v-if="isOpen" class="relative">
            <div
                class="absolute top-2 left-0 right-0 bg-forest-400 border border-earth-150 rounded-lg shadow-lg max-h-80 overflow-y-auto z-50">

                <div v-for="category in items" :key="category.id">
                    <div
                        class="sticky top-0 px-4 py-3 bg-earth-150 text-forest-400 font-bold flex items-center justify-between shadow-sm border-b-2 border-earth-200">
                        <span>{{ category.name }}</span>
                    </div>

                    <div class="bg-white">
                        <div v-for="item in category[itemsKey]" :key="item.id"
                            class="group px-6 py-3 hover:bg-earth-150/20 cursor-pointer transition-colors border-l-4 border-transparent hover:border-earth-150 flex items-center justify-between"
                            @click="selectItem(item)">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ item.name }}</div>
                                <div v-if="item.description" class="text-sm text-gray-500 mt-1">{{ item.description }}
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg v-if="isSelected(item)" class="h-5 w-5 text-earth-150 group-hover:text-earth-200" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, useTemplateRef } from "vue";
import { onClickOutside } from '@vueuse/core';

const props = defineProps({
    itemsKey: {
        type: String,
        default: 'items'
    },
    items: {
        type: Array,
        required: true
    },
    placeholder: {
        type: String,
        default: "Seleccionar..."
    },
    modelValue: {
        type: [String, Number],
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const target = useTemplateRef('target')

const selectedItem = computed(() => {
    if (!props.modelValue) return null

    for (const category of props.items) {
        if (category[props.itemsKey] && category[props.itemsKey].length) {
            const found = category[props.itemsKey].find(item => item.id == props.modelValue)
            if (found) return found
        } else if (category.id == props.modelValue) {
            return category
        }
    }
    return null
})

const isSelected = (item) => {
    return item.id == props.modelValue
}

const selectItem = (item) => {
    emit('update:modelValue', String(item.id))
    close()
}

const clearSelection = () => {
    emit('update:modelValue', '')
    close()
}

const toggle = () => {
    isOpen.value = !isOpen.value
}

const close = () => {
    isOpen.value = false
}

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && isOpen.value) {
        close()
    }
}

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape)
})

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape)
})

onClickOutside(target, () => close())
</script>
