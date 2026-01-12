<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox :has-border="false">
            <DataForm :form="form" />
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="info" label="Guardar"
                        :processing="form.processing"  />
                    <BaseButton color="danger" :icon="mdiTrashCan" @click="deleteForm" label="Eliminar"  />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiCheck, mdiTrashCan } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import { useForm } from "@inertiajs/vue3";
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";
import { error422 } from "@/Hooks/useErrorsForm";
import { useLoading } from "@/Hooks/useLoading";

const { isLoading, setLoading } = useLoading();

const props = defineProps({
    name: 'Edit',
    title: {
        type: String,
        required: true
    },
    equipmentType: {
        type: Object,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
});

const form = useForm({
    name: props.equipmentType.name,
    description: props.equipmentType.description,
});

const saveForm = () => {
    form.put(route(`${props.routeName}update`, props.equipmentType.id), {
        onBefore: () => {
            setLoading(true);
        },
        onError: () => {
            error422();
        },
        onFinish: () => {
            setLoading(false);
        },
    });
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, props.equipmentType.id));
        }
    });
};
</script>