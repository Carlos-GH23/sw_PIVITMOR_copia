<template>
    <Modal :show="show" :closeable="true" @close="closeModal" maxWidth="5xl">
        <div class="flex flex-col xl:flex-row xl:h-[600px]">
            <div class="w-full xl:w-1/3 border-b xl:border-r border-gray-200 p-6 overflow-y-auto">
                <div class="mb-6">
                    <h2 class="text-xl font-medium mb-2">
                        Filtros de oportunidad
                    </h2>
                </div>

                <div>
                    <FilterBase @click="handleFilter('resource_types')" label="Búsqueda"
                        :isActive="activeFilter === 'resource_types'" :count="filters.resource_types.length" />
                    <FilterBase @click="handleFilter('intellectual_property')" label="Propiedad intelectual"
                        :isActive="activeFilter === 'intellectual_property'"
                        :count="filters.intellectual_property_ids.length" />
                    <FilterBase @click="handleFilter('institution_type')" label="Tipo de institución"
                        :isActive="activeFilter === 'institution_type'" :count="filters.institution_codes.length" />
                    <FilterBase @click="handleFilter('keywords')" label="Coincidencia de palabras"
                        :isActive="activeFilter === 'keywords'" :count="filters.keywords.length" />

                    <div class="p-3">
                        <button @click="resetFilters"
                            class="text-gray-600 hover:text-gray-900 text-sm underline cursor-pointer transition-colors">
                            Reestablecer filtros
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-6 overflow-y-auto">
                <template v-if="activeFilter === 'resource_types'">
                    <div class="space-y-4">
                        <div v-for="(resourceType, key) in resourceTypes" :key="key">
                            <FormCheckRadio :component-class="checkBoxClass" type="checkbox"
                                v-model="filters.resource_types" name="resource_types" :input-value="key"
                                :label="resourceType" labelClass="text-md " />
                        </div>
                    </div>
                </template>

                <template v-if="activeFilter === 'intellectual_property'">
                    <div class="space-y-4">
                        <div v-for="(intellectualProperty) in intellectualProperties" :key="intellectualProperty.id">
                            <FormCheckRadio :component-class="checkBoxClass" type="checkbox"
                                v-model="filters.intellectual_property_ids" name="intellectual_property_ids"
                                :input-value="intellectualProperty.id" :label="intellectualProperty.name" />
                        </div>
                    </div>
                </template>

                <template v-if="activeFilter === 'institution_type'">
                    <div class="space-y-4">
                        <div v-for="(institutionType, key) in institutionTypes" :key="key">
                            <FormCheckRadio :component-class="checkBoxClass" type="checkbox"
                                v-model="filters.institution_codes" name="institution_codes" :input-value="key"
                                :label="institutionType" />
                        </div>
                    </div>
                </template>

                <template v-if="activeFilter === 'keywords'">
                    <FormField label="Palabras clave">
                        <KeywordInput v-model="filters.keywords" />
                    </FormField>
                </template>

                <div v-if="activeFilter === null" class="flex flex-col items-center justify-center text-center h-full">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    <p class="text-gray-500">Selecciona una categoría para ver las opciones disponibles</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 p-4 bg-gray-50">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 hidden md:block">
                    {{ filters.resource_types.length + filters.intellectual_property_ids.length +
                        filters.institution_codes.length + filters.keywords.length }} filtro(s) aplicado(s)
                </span>
                <div class="flex-1 md:flex-none space-x-3 text-right">
                    <BaseButton :icon="mdiClose" label="Cancelar" @click="closeModal" color="lightDark" />
                    <BaseButton label="Aplicar filtros" @click="applyFilters" color="success" :icon="mdiCheckBold" />
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import BaseButton from '@/Components/BaseButton.vue';
import FilterBase from './FilterBase.vue';
import FormField from '@/Components/FormField.vue';
import FormCheckRadio from '@/Components/FormCheckRadio.vue';
import KeywordInput from '@/Components/KeywordInput.vue'
import Modal from '@/Components/Modal.vue'
import { resourceTypes, institutionTypes } from '../Utils/resources';
import { mdiCheckBold, mdiClose } from '@mdi/js';
import { reactive, ref, watch } from 'vue';

defineProps({
    show: {
        type: Boolean,
        required: true
    },
    intellectualProperties: {
        type: Array,
        required: true
    },
});

const modelValue = defineModel();

const filters = reactive({ ...modelValue.value });

const activeFilter = ref(null);

const emit = defineEmits(['close', 'applyFilters']);

const handleFilter = (filter) => {
    activeFilter.value = filter;
};

const applyFilters = () => {
    Object.assign(modelValue.value, filters);
    emit('applyFilters');
    emit('close');
};

const resetFilters = () => {
    filters.keywords = [];
    filters.resource_types = [];
    filters.intellectual_property_ids = [];
    filters.institution_codes = [];
};

const closeModal = () => {
    Object.assign(filters, modelValue.value);
    emit('close');
};

watch(modelValue, () => {
    Object.assign(filters, modelValue.value);
}, { deep: true });

const checkBoxClass = 'hover:bg-gray-50 w-full p-2 rounded-lg';
</script>