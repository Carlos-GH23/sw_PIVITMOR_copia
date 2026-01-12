<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm>
            <DataForm :form="form" is-edit />
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="form.processing" />
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
import { useForm } from "@inertiajs/vue3";
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
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
    serviceCategory: {
        type: Object,
        required: true
    },
});

const form = useForm({
    id: props.serviceCategory.data?.id || props.serviceCategory.id,
    code: props.serviceCategory.data?.code || props.serviceCategory.code || '',
    name: props.serviceCategory.data?.name || props.serviceCategory.name || '',
    description: props.serviceCategory.data?.description || props.serviceCategory.description || '',
});

const saveForm = () => {
    const id = props.serviceCategory.data?.id || props.serviceCategory.id;
    form.put(route(`${props.routeName}update`, id));
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            const id = props.serviceCategory.data?.id || props.serviceCategory.id;
            form.delete(route(`${props.routeName}destroy`, id));
        }
    });
};
</script>
