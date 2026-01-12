<template>
    <div class="space-y-3">
        <div class="w-full grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <FormControl v-model="initial" :options="technologyLevels" placeholder="Selecciona el TRL inicial"
                    :icon="mdiRayStartArrow" />
            </div>
            <div class="flex items-center justify-center sm:col-span-1">
                <BaseIcon :path="mdiArrowRightBold" />
            </div>
            <div class="sm:col-span-5">
                <FormControl v-model="final" :options="technologyLevels" placeholder="Selecciona el TRL final"
                    :icon="mdiRayEndArrow" />
            </div>
            <div class="sm:col-span-1 flex sm:justify-end">
                <BaseButton color="lightDark" :icon="mdiPlus" label="Agregar" @click="addTransition"
                    class="w-full sm:w-auto" />
            </div>
        </div>

        <div class="flex justify-end">
            <Badge>
                {{ transitions.length }} incrementos
            </Badge>
        </div>

        <div class="space-y-2 max-h-74 overflow-y-auto">
            <div v-for="(item, index) in transitions" :key="index"
                class="flex items-center justify-between border rounded px-3 py-2">
                <div class="flex items-center gap-3">
                    <div
                        class="bg-forest-100 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                        {{ index + 1 }}
                    </div>

                    <strong>
                        {{technologyLevels.find(transition => transition.id === item.initial_id)?.name}}
                        <InputError :message="errors[`technology_level_transitions.${index}.initial_id`]" />
                    </strong>
                    <BaseIcon :path="mdiArrowRightBold" />
                    <strong>
                        {{technologyLevels.find(transition => transition.id === item.final_id)?.name}}
                        <InputError :message="errors[`technology_level_transitions.${index}.final_id`]" />
                    </strong>
                </div>
                <BaseButton :icon="mdiTrashCan" title="Eliminar" @click="removeTransition(index)" rounded-full />
            </div>
        </div>
    </div>
</template>
<script setup>
import Badge from '@/Components/Badge.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import FormControl from '@/Components/FormControl.vue';
import InputError from '@/Components/InputError.vue';
import { mdiArrowRightBold, mdiPlus, mdiRayEndArrow, mdiRayStartArrow, mdiTrashCan } from '@mdi/js';
import { ref } from 'vue';

const props = defineProps({
    technologyLevels: {
        type: Array,
        default: () => []
    },
    errors: {
        type: Object,
        default: () => ({})
    },
});

const transitions = defineModel({ type: Array });

const initial = ref(null);
const final = ref(null);

const addTransition = () => {
    if (!initial.value || !final.value) return;

    const exists = transitions.value.some(
        item => item.initial === initial.value && item.final === final.value
    );

    if (exists) return;

    transitions.value.push({
        initial_id: initial.value,
        final_id: final.value,
    });

    initial.value = null;
    final.value = null;
};

const removeTransition = (index) => {
    transitions.value.splice(index, 1);
};
</script>