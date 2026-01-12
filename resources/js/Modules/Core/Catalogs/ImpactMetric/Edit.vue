<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm :title="`${routeName}edit`">
            <FormField label="Nombre de la métrica:" required :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Ingresa la métrica" type="textarea" height="h-24" />
            </FormField>

            <FormField label="Tipo de métrica:" :error="form.errors.type">
                <FormControl v-model="form.type" :options="types" valueSelect="value" valueOption="label" />
            </FormField>
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="form.processing" />
                    <BaseButton @click="deleteForm" :icon="mdiTrashCan" color="danger" label="Eliminar" />
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
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
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
    impactMetric: {
        type: Object,
        required: true
    },
    types: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    id: props.impactMetric.data.id,
    name: props.impactMetric.data.name,
    type: props.impactMetric.data.type,
});

const saveForm = () => {
    form.put(route(`${props.routeName}update`, props.impactMetric.data.id));
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, props.impactMetric.data.id));
        }
    });
};
</script>