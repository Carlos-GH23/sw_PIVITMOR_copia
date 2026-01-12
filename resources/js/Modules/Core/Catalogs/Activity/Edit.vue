<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox :has-border="false">
            <DataForm :activities="activities" :form="form" :activity_children="activity_children" />
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
import { mdiPlus, mdiClose, mdiCheck, mdiTrashCan } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import { useForm } from "@inertiajs/vue3";
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { messageConfirm } from "@/Hooks/useErrorsForm";

const props = defineProps({
    name: 'Edit',
    title: {
        type: String,
        required: true
    },
    activity: {
        type: Object,
        required: true
    },
    activities: {
        type: Object,
        required: true
    },
    activity_children: {
        type: Object,
        required: false
    },
    routeName: {
        type: String,
        required: true
    },
});
const form = useForm({
    name: props.activity.name,
    description: props.activity.description,
    child_ids: props.activity.children ? props.activity.children.map(child => child.id) : [],
    removed_children_ids: [],
});
const saveForm = () => {
    form.put(route(`${props.routeName}update`, props.activity.id));
}
const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, props.activity.id));
        }
    });
};
</script>