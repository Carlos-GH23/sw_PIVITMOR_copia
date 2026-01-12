<template>
    <CardBox>
        <div class="grid grid-cols-1 md:grid-cols-1 space-x-2 mb-6 md:mb-0">
            <FormField label="Nombre de la actividad:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre de la actividad" />
            </FormField>
            <FormField label="Descripción:" :error="form.errors.description">
                <FormControl v-model="form.description" placeholder="Descripción" type="textarea" height="h-24"
                    maxLength="2000" />
            </FormField>
        </div>
    </CardBox>
    <div class="md:flex md:space-x-4 my-2">
        <CardBox class="md:w-6/12 p-2 max-lg:mb-5 h-[550px]">
            <SectionTitleLineWithButton title="Actividades" :hisBreadCrumb="false"
                :description="`${activities.length} actividades disponibles`" />

            <div class="flex flex-col space-y-2 overflow-y-auto h-full">
                <CardBoxComponentEmpty v-if="activities.length === 0" icon="mdiViewSequential"
                    message="No hay actividades disponibles" />
                <a v-for="item in activities" :key="item.id" @click="toggleChild(item.id)" :class="[
                    'p-4 rounded-lg border-2 cursor-pointer transition-all duration-200',
                    selectedChildren.includes(item.id)
                        ? 'border-blue-500 bg-blue-50 text-blue-700'
                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800']">
                    <div class="flex items-center justify-between">
                        <span class="font-medium ">{{ item.name }}</span>
                        <div v-if="selectedChildren.includes(item.id)" class="w-2 h-2 bg-blue-500 rounded-full" />
                    </div>
                </a>
            </div>
        </CardBox>
        <CardBox class="md:w-6/12 p-2 max-lg:mb-5 h-[550px]">
            <SectionTitleLineWithButton title="Actividades seleccionadas" :hisBreadCrumb="false"
                :description="`${activity_children.length} actividades asociadas`" />
            <div class="flex flex-col space-y-2 overflow-y-auto h-full">
                <CardBoxComponentEmpty v-if="activity_children.length === 0" icon="mdiViewSequential"
                    message="No hay subactividades seleccionadas" />
                <a v-for="item in activity_children" :key="item.id" @click="toggleChild(item.id)" :class="[
                    'p-4 rounded-lg border-2 cursor-pointer transition-all duration-200',
                    selectedChildren.includes(item.id)
                        ? 'border-blue-500 bg-blue-50 text-blue-700'
                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800']">
                    <div class="flex items-center justify-between">
                        <span class="font-medium ">{{ item.name }}</span>
                        <div v-if="selectedChildren.includes(item.id)" class="w-2 h-2 bg-blue-500 rounded-full" />
                    </div>
                </a>
            </div>
        </CardBox>
    </div>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiCheckAll, mdiReplyAll, mdiViewSequential, mdiShieldCheck, mdiMagnify } from "@mdi/js";
import { defineProps } from 'vue';

import { ref, onMounted } from 'vue';
const selectedChildren = ref([]);
const removedChildren = ref([]);


onMounted(() => {
    // Inicializa con los hijos actuales si existen
    if (activity_children && Object.values(activity_children).length > 0) {
        selectedChildren.value = Object.values(activity_children).map(child => child.id);
    } else if (Array.isArray(form.child_ids)) {
        selectedChildren.value = [...form.child_ids];
    }
    form.child_ids = [...selectedChildren.value];
    form.removed_children_ids = [];
});

function toggleChild(id) {
    const idx = selectedChildren.value.indexOf(id);
    const wasInitiallyChild = activity_children && Object.values(activity_children).some(child => child.id === id);
    if (idx === -1) {
        selectedChildren.value.push(id);
        // Si lo agregas, quítalo de los eliminados
        removedChildren.value = removedChildren.value.filter(rid => rid !== id);
    } else {
        selectedChildren.value.splice(idx, 1);
        // Si era hijo originalmente, agrégalo a los eliminados
        if (wasInitiallyChild) {
            if (!removedChildren.value.includes(id)) {
                removedChildren.value.push(id);
            }
        }
    }
    form.child_ids = [...selectedChildren.value];
    form.removed_children_ids = [...removedChildren.value];
}
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";

const { activities, form, activity_children } = defineProps({
    activities: {
        type: Object,
        required: true
    },
    form: {
        type: Object,
        required: true
    },
    activity_children: {
        type: Object,
        required: false
    }
});
</script>