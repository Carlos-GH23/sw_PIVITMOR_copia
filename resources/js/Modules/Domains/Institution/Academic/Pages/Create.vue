<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <AcademicForm>
            <BaseButtons class="flex justify-end space-x-2">
                <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                <BaseButton @click="storeForm" :icon="mdiCheck" color="success" label="Guardar"
                    :processing="processing" />
            </BaseButtons>
        </AcademicForm>
    </LayoutMain>
</template>

<script setup>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiCheck } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useAcademicForm } from "../Composables/useAcademicForm.js"
import AcademicForm from "../Components/AcademicForm.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
    positions: {
        type: Array,
        required: true,
    },
    academicDegrees: {
        type: Array,
        required: true,
    },
    sniiAreas: {
        type: Array,
        required: true,
    },
    sniiLevels: {
        type: Array,
        required: true,
    },
    departments: {
        type: Array,
        required: true,
    },
    oecdSectors: {
        type: Object,
        required: true,
    },
    economicSectors: {
        type: Object,
        required: true,
    },
    genders: {
        type: Array,
        required: true,
    },
});

const { processing, storeForm } = useAcademicForm(props);
</script>
