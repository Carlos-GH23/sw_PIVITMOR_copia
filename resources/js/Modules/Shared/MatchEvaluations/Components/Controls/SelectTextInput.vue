<template>
    <div class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <FormControl v-model="option" :options="options" />
            </div>

            <div class="sm:col-span-5">
                <FormControl v-model="name" placeholder="Ingresa una descripción"
                    @keydown.enter.prevent="addParticipation" max-length="255" />
            </div>

            <div class="sm:col-span-2 flex sm:justify-end">
                <BaseButton color="lightDark" :icon="mdiPlus" label="Agregar" @click="addParticipation"
                    class="w-full sm:w-auto" />
            </div>
        </div>

        <div class="flex justify-end">
            <Badge>
                {{ model.length }} {{ label }}
            </Badge>
        </div>

        <div class="space-y-2 max-h-[330px] overflow-y-auto pr-1">
            <div v-for="(item, index) in model" :key="index"
                class="flex justify-between items-center border rounded-lg px-3 py-2 bg-white shadow-sm">
                <div class="flex items-center gap-3">
                    <div
                        class="bg-forest-100 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs font-bold">
                        {{ index + 1 }}
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="font-semibold text-sm">
                            {{options.find(f => f.id === item[props.selectOption])?.name}}
                        </span>
                        <span class="text-gray-700 text-sm">
                            {{ item[props.textOption] }}
                        </span>
                    </div>
                </div>
                <BaseButton :icon="mdiTrashCan" title="Eliminar" @click="removeParticipation(index)" rounded-full />
            </div>
        </div>
    </div>
</template>
<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import FormControl from '@/Components/FormControl.vue';
import { mdiPlus, mdiTrashCan } from '@mdi/js';
import { ref } from 'vue';

const props = defineProps({
    options: {
        type: Array,
        default: () => []
    },
    selectOption: {
        type: String,
        required: true
    },
    textOption: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    },
});

const model = defineModel({ type: Array });

const option = ref(null);
const name = ref(null);

const addParticipation = () => {
    if (!option.value || !name.value) return;

    model.value.push({
        [props.selectOption]: option.value,
        [props.textOption]: name.value,
    });

    option.value = null;
    name.value = null;
};

const removeParticipation = (index) => {
    model.value.splice(index, 1);
};
</script>
