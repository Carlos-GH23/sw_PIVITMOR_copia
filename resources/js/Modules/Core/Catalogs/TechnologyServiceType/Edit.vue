<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <CardBox isForm>
            <DataForm :form="form" :categories="categories" />
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="updateForm" :icon="mdiCheck" color="success" label="Guardar"
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
import { mdiPencil, mdiClose, mdiCheck, mdiTrashCan } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import { useForm } from "@inertiajs/vue3";
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useLoading } from "@/Hooks/useLoading";
import { error422, messageConfirm } from "@/Hooks/useErrorsForm";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    serviceType: {
        type: Object,
        required: true
    },
    categories: {
        type: Object,
        required: false,
        default: () => ({ data: [] })
    }
});

const form = useForm({
    id: props.serviceType.data?.id,
    code: props.serviceType.data?.code,
    name: props.serviceType.data?.name,
    description: props.serviceType.data?.description,
    category_id: props.serviceType.data?.category_id ?? null,
});

const { setLoading } = useLoading();

const updateForm = () => {
    form.put(route(`${props.routeName}update`, props.serviceType.data?.id), {
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
            form.delete(route(`${props.routeName}destroy`, props.serviceType.data?.id));
        }
    });
};
</script>
