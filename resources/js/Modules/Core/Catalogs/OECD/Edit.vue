<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm>
            <DataForm :form="form" :categories="categories" :economicSocialSectors="economicSocialSectors"
                :levelOptions="levelOptions" />
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar" />
                    <BaseButton color="danger" :icon="mdiTrashCan" @click="deleteForm" label="Eliminar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPencil, mdiTrashCan, mdiClose, mdiCheck } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useForm } from "@inertiajs/vue3";
import { messageConfirm } from "@/Hooks/useErrorsForm";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    categories: {
        type: Array,
        default: () => [],
    },
    oecdSector: {
        type: Object,
        required: true,
    },
    economicSocialSectors: {
        type: Array,
        default: () => [],
    },
    levelOptions: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: props.oecdSector.name || '',
    parent_id: typeof props.oecdSector.parent_id === 'object' && props.oecdSector.parent_id !== null
        ? props.oecdSector.parent_id.value
        : props.oecdSector.parent_id || null,
    economic_social_sector_id: props.oecdSector.economic_social_sector_id || null,
    level: props.oecdSector.level || null,
});

const saveForm = () => {
    form.put(route(`${props.routeName}update`, props.oecdSector.id));
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, props.oecdSector.id));
        }
    });
};
</script>