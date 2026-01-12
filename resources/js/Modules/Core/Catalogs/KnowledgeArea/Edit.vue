<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox>
            <div class="grid grid-cols-1 md:grid-cols-2 space-x-2 mb-6 md:mb-0">
                <FormField label="Nombre del Área de Conocimiento:" required help="Nombre del área de conocimiento"
                    :error="form.errors.name">
                    <FormControl v-model="form.name" placeholder="Nombre del área de conocimiento" required />
                </FormField>

                <FormField label="Área de Conocimiento Padre:"
                    help="Seleccione un área de conocimiento principal (opcional)" :error="form.errors.parent_id">
                    <FormControl v-model="form.parent_id" :options="parentAreas"
                        :label-options="{ key: 'id', label: 'name' }" />
                </FormField>
            </div>

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
    area: {
        type: Object,
        required: true
    },
    parentAreas: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: props.area.name,
    parent_id: props.area.parent_id,
});

const saveForm = () => {
    form.put(route(`${props.routeName}update`, props.area.id));
};

const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, props.area.id));
        }
    });
};
</script>