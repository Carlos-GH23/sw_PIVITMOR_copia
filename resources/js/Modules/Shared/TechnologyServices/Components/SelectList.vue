<template>
    <div @keyup.esc="closeOnEscape" class="space-y-2">
        <div class="relative">
            <input v-model="searchQuery" type="text" :placeholder="placeholder"
                class="w-full px-4 py-2.5 pr-10 border bg-white text-black dark:text-slate-200 dark:bg-slate-800 border-slate-400 dark:border-slate-400 rounded focus:ring-2 focus:ring-forest-100 focus:border-forest-100 transition-colors"
                @focus="open" @keypress="open" />
            <Search class="absolute right-3 top-3.5 h-4 w-4 text-gray-400" />
        </div>

        <div v-if="isOpen" ref="target" class="relative">
            <div
                class="absolute top-2 left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg max-h-80 overflow-y-auto z-10">
                <div v-if="filteredItems.length === 0" class="p-4 text-gray-500 text-center">
                    No se encontraron resultados
                </div>

                <div v-for="item in filteredItems" :key="item.id"
                    class="group px-6 py-3 hover:bg-forest-50 cursor-pointer transition-colors border-l-4 border-transparent hover:border-forest-100 flex items-center justify-between group"
                    @click="selectItem(item)">
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">{{ item.name }}</div>
                        <div class="text-sm text-gray-500 mt-1">{{ item.description }}</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <CircleCheckBig v-if="isSelected(item)"
                            class="h-5 w-5 with text-success-400 group-hover:text-forest-400" />
                        <Plus v-else class="h-4 w-4 text-forest-100 group-hover:text-forest-400" />
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selectedItems.length > 0" class="space-y-3">
            <h3 class="text-sm font-medium text-gray-700 dark:text-slate-200">
                Seleccionados ({{ selectedItems.length }})
            </h3>

            <div class="space-y-2">
                <div v-for="item in selectedItems" :key="item.id"
                    class="group flex items-center justify-between p-3 bg-mono-100 dark:bg-slate-800 border border-forest-50 rounded-lg group hover:bg-forest-100 transition-colors">
                    <div class="flex-1">
                        <div class="font-medium text-forest-400 group-hover:text-white dark:text-blue-600">{{ item.name
                            }}</div>
                        <div class="text-sm text-blue-600">{{ item.description }}</div>
                    </div>
                    <button title="Eliminar" @click="removeItem(item)"
                        class="hover:cursor-pointer p-1 text-black group-hover:bg-white rounded transition-colors">
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>
        <CardBoxComponentEmpty v-else />
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, useTemplateRef } from "vue";
import { Search, CircleCheckBig, Plus, X } from "lucide-vue-next";
import { onClickOutside } from '@vueuse/core';
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";

const props = defineProps({
    modelValue: { type: Array, default: () => [] },
    items: { type: Array, required: true },
    placeholder: { type: String, default: "Buscar..." }
})

const emit = defineEmits(["update:modelValue"])

const searchQuery = ref("")
const isOpen = ref(false)
const selectedItems = ref([]);
const target = useTemplateRef('target');

const filteredItems = computed(() => {
    if (!searchQuery.value) return props.items
    return props.items.filter(item =>
        [item.name, item.description].some(text =>
            (text ?? '').toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    )
})

const isSelected = (item) => selectedItems.value.some(sel => sel.id === item.id)

const selectItem = (item) => {
    if (!isSelected(item)) {
        selectedItems.value = [...selectedItems.value, item];
        emit("update:modelValue", selectedItems.value.map(i => i.id))
    } else {
        removeItem(item);
    }
};

const removeItem = (item) => {
    selectedItems.value = selectedItems.value.filter(sel => sel.id !== item.id)
    emit("update:modelValue", selectedItems.value.map(i => i.id))
}

watch(
    () => props.modelValue,
    (newVal) => {
        if (selectedItems.value.length === 0 && newVal.length > 0) {
            selectedItems.value = props.items.filter(item => newVal.includes(item.id));
        }
    },
    { immediate: true, deep: true }
)
const open = () => {
    isOpen.value = true;
};

const close = () => {
    isOpen.value = false;
};


const closeOnEscape = (e) => {
    if (e.key === 'Escape' && isOpen.value) {
        close();
    }
};


onMounted(() => {
    if (props.modelValue.length === 0) return;
    const selectedIds = new Set(props.modelValue);

    selectedItems.value = props.items.filter(item => selectedIds.has(item.id));

    document.addEventListener('keydown', closeOnEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
});

onClickOutside(target, () => close());
</script>
