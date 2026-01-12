<template>
    <div @keyup.esc="close" class="relative" ref="target">
        <div class="relative">
            <input v-model="searchQuery" type="text" :placeholder="placeholder"
                class="w-full px-4 py-2.5 pr-20 border bg-white text-black dark:text-slate-200 dark:bg-slate-800 border-slate-400 dark:border-slate-400 rounded focus:ring-2 focus:ring-wine-50 focus:border-wine-50 transition-colors text-left cursor-text hover:border-wine-100"
                @focus="open" @click="open" @keypress="open" />

            <div class="absolute right-3 top-3.5 cursor-pointer" @click.stop="toggle">
                <ChevronDown :class="['h-4 w-4 text-gray-400 transition-transform', isOpen ? 'rotate-180' : '']" />
            </div>

            <button v-if="modelValue" @click.stop="clearSelection" type="button" title="Limpiar filtro"
                class="absolute right-9 top-3.5 text-gray-400 hover:text-wine-50 transition-colors">
                <X class="h-4 w-4" />
            </button>
        </div>

        <div v-if="isOpen" class="relative">
            <div
                class="absolute top-2 left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg max-h-80 overflow-y-auto z-10">

                <div v-for="level1 in filteredItems" :key="level1.id" class="border-b border-gray-100 last:border-b-0">
                    <div
                        class="group sticky top-0 px-4 py-3 bg-wine-50 text-white font-bold flex items-center justify-between shadow-none border-b-2 border-wine-50">
                        <div class="flex items-center gap-2 flex-1 cursor-pointer" @click="toggleLevel1(level1.id)">
                            <ChevronRight v-if="!expandedLevel1.has(level1.id)" class="h-4 w-4" />
                            <ChevronDown v-else class="h-4 w-4" />
                            <span>{{ level1.name }}</span>
                        </div>
                        <button @click.stop="selectItem(level1)" class="hover:bg-wine-100 rounded p-1 transition-colors"
                            title="Seleccionar">
                            <CircleCheckBig v-if="isSelected(level1)" class="h-5 w-5" />
                            <Plus v-else class="h-5 w-5 opacity-0 group-hover:opacity-100 transition-opacity" />
                        </button>
                    </div>

                    <div v-if="expandedLevel1.has(level1.id)" class="bg-white">
                        <div v-if="level1[itemsKey] && level1[itemsKey].length">
                            <div v-for="level2 in level1[itemsKey]" :key="level2.id">
                                <div class="group px-6 py-3 hover:bg-wine-50/10 cursor-pointer transition-colors border-l-4 border-transparent hover:border-wine-50 flex items-center justify-between"
                                    @click="level2.children && level2.children.length ? toggleLevel2(level2.id) : selectItem(level2)">
                                    <div class="flex-1 flex items-center gap-2">
                                        <ChevronRight
                                            v-if="level2.children && level2.children.length && !expandedLevel2.has(level2.id)"
                                            class="h-3 w-3 text-gray-400" />
                                        <ChevronDown v-else-if="level2.children && level2.children.length"
                                            class="h-3 w-3 text-gray-400" />
                                        <div class="flex-1">
                                            <div class="font-medium"
                                                :class="isSelected(level2) ? 'text-wine-50' : 'text-gray-900'">{{
                                                    level2.name }}</div>
                                            <div v-if="level2.description" class="text-sm text-gray-500 mt-1">{{
                                                level2.description }}</div>
                                        </div>
                                    </div>
                                    <button @click.stop="selectItem(level2)"
                                        class="hover:bg-wine-50/20 rounded p-1 transition-colors" title="Seleccionar">
                                        <CircleCheckBig v-if="isSelected(level2)"
                                            class="h-5 w-5 text-wine-50 group-hover:text-wine-100" />
                                        <Plus v-else
                                            class="h-4 w-4 text-wine-100 opacity-0 group-hover:opacity-100 transition-opacity" />
                                    </button>
                                </div>

                                <div v-if="expandedLevel2.has(level2.id) && level2.children && level2.children.length"
                                    class="bg-gray-50">
                                    <div v-for="level3 in level2.children" :key="level3.id"
                                        class="group px-10 py-2.5 hover:bg-wine-50/10 cursor-pointer transition-colors border-l-4 border-transparent hover:border-wine-50 flex items-center justify-between ml-6"
                                        @click="selectItem(level3)">
                                        <div class="flex-1">
                                            <div class="font-medium text-sm"
                                                :class="isSelected(level3) ? 'text-wine-50' : 'text-gray-700'">{{
                                                    level3.name }}</div>
                                            <div v-if="level3.description" class="text-xs text-gray-500 mt-1">{{
                                                level3.description }}</div>
                                        </div>
                                        <button @click.stop="selectItem(level3)"
                                            class="hover:bg-wine-50/20 rounded p-1 transition-colors"
                                            title="Seleccionar">
                                            <CircleCheckBig v-if="isSelected(level3)"
                                                class="h-5 w-5 text-wine-50 group-hover:text-wine-100" />
                                            <Plus v-else
                                                class="h-4 w-4 text-wine-100 opacity-0 group-hover:opacity-100 transition-opacity" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, useTemplateRef } from "vue";
import { ChevronDown, ChevronRight, X, CircleCheckBig, Plus } from "lucide-vue-next";
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
const searchQuery = ref("")
const expandedLevel1 = ref(new Set())
const expandedLevel2 = ref(new Set())

const filteredItems = computed(() => {
    const query = searchQuery.value?.toLowerCase() ?? "";

    if (selectedItem.value && query === selectedItem.value.name.toLowerCase()) {
        return props.items;
    }

    if (!query) return props.items;

    const filterHierarchy = (items, level = 1) => {
        return items.map(item => {
            const nameMatches = item.name?.toLowerCase().includes(query);
            const descMatches = item.description?.toLowerCase().includes(query);

            let filteredChildren = [];
            let hasMatchingDescendants = false;

            if (level === 1 && item[props.itemsKey] && item[props.itemsKey].length) {
                filteredChildren = item[props.itemsKey].map(child => {
                    const childNameMatches = child.name?.toLowerCase().includes(query);
                    const childDescMatches = child.description?.toLowerCase().includes(query);

                    let filteredGrandchildren = [];
                    let hasMatchingGrandchildren = false;

                    if (child.children && child.children.length) {
                        filteredGrandchildren = child.children.filter(grandchild => {
                            const grandchildNameMatches = grandchild.name?.toLowerCase().includes(query);
                            const grandchildDescMatches = grandchild.description?.toLowerCase().includes(query);
                            return grandchildNameMatches || grandchildDescMatches;
                        });

                        hasMatchingGrandchildren = filteredGrandchildren.length > 0;

                        if (hasMatchingGrandchildren) {
                            expandedLevel2.value.add(child.id);
                        }
                    }

                    if (childNameMatches || childDescMatches || hasMatchingGrandchildren) {
                        return {
                            ...child,
                            children: hasMatchingGrandchildren ? filteredGrandchildren : child.children
                        };
                    }
                    return null;
                }).filter(child => child !== null);

                hasMatchingDescendants = filteredChildren.length > 0;

                if (hasMatchingDescendants) {
                    expandedLevel1.value.add(item.id);
                }
            }

            if (nameMatches || descMatches || hasMatchingDescendants) {
                return {
                    ...item,
                    [props.itemsKey]: filteredChildren
                };
            }
            return null;
        }).filter(item => item !== null);
    };

    return filterHierarchy(props.items);
});

const selectedItem = computed(() => {
    if (!props.modelValue) return null

    for (const category of props.items) {
        if (category.id == props.modelValue) return category

        if (category[props.itemsKey] && category[props.itemsKey].length) {
            const level2Found = category[props.itemsKey].find(item => item.id == props.modelValue)
            if (level2Found) return level2Found
            for (const level2 of category[props.itemsKey]) {
                if (level2.children && level2.children.length) {
                    const level3Found = level2.children.find(item => item.id == props.modelValue)
                    if (level3Found) return level3Found
                }
            }
        }
    }
    return null
})

watch(selectedItem, (newItem) => {
    if (newItem) {
        searchQuery.value = newItem.name
    } else {
        searchQuery.value = ''
    }
}, { immediate: true })

watch(isOpen, (newVal) => {
    if (!newVal && selectedItem.value) {
        searchQuery.value = selectedItem.value.name
    } else if (!newVal && !selectedItem.value) {
        searchQuery.value = ''
    }
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

const open = () => {
    isOpen.value = true
}

const close = () => {
    isOpen.value = false
}

const toggleLevel1 = (id) => {
    if (expandedLevel1.value.has(id)) {
        expandedLevel1.value.delete(id)
    } else {
        expandedLevel1.value.add(id)
    }
}

const toggleLevel2 = (id) => {
    if (expandedLevel2.value.has(id)) {
        expandedLevel2.value.delete(id)
    } else {
        expandedLevel2.value.add(id)
    }
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