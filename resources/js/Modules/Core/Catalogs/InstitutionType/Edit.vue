<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm>
            <DataForm :form="form" :institutionCategories="institutionCategories" />
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
    institutionType: {
        type: Object,
        required: true
    },
    institutionCategories: {
        type: Array,
        required: true
    }
});

const form = useForm({
    id: props.institutionType.data?.id || props.institutionType.id,
    code: props.institutionType.data?.code || props.institutionType.code || '',
    name: props.institutionType.data?.name || props.institutionType.name || '',
    description: props.institutionType.data?.description || props.institutionType.description || '',
    institution_category_id:
        props.institutionType.data?.institution_category?.id ||
        props.institutionType.institution_category?.id ||
        props.institutionType.data?.institution_category_id ||
        props.institutionType.institution_category_id ||
        null,
});

const saveForm = () => {
    const id = props.institutionType.data?.id || props.institutionType.id;
    form.put(route(`${props.routeName}update`, id));
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            const id = props.institutionType.data?.id || props.institutionType.id;
            form.delete(route(`${props.routeName}destroy`, id));
        }
    });
};
</script>
