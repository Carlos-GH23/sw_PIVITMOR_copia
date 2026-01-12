<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm>
            <DataForm :form="form" />
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="updateForm" :icon="mdiCheck" color="success" label="Actualizar"
                        :processing="form.processing" />
                    <BaseButton @click="deleteForm" :icon="mdiTrashCan" color="danger" label="Eliminar"
                        :processing="form.processingDelete" />
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
import { messageConfirm } from "@/Hooks/useErrorsForm";

const props = defineProps({
    title: { type: String, required: true },
    routeName: { type: String, required: true },
    intellectualProperty: { type: Object, required: true },
});

const intellectualPropertyData = props.intellectualProperty.data ?? props.intellectualProperty;

const form = useForm({
    name: props.intellectualProperty.data.name,
});

const updateForm = () => {
    form.put(route(`${props.routeName}update`, {
        intellectualProperty: props.intellectualProperty.data.id
    }));
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, {
                intellectualProperty: intellectualPropertyData.id
            }));
        }
    });
};
</script>
