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
    technology_level: {
        type: Object,
        required: true
    },
});

const form = useForm({
    level: props.technology_level.level,
    name: props.technology_level.name,
});

const saveForm = () => {
    form.put(route(`${props.routeName}update`, props.technology_level.id));
};
const deleteForm = () => {
    messageConfirm().then((res) => {
        if (res.isConfirmed) {
            form.delete(route(`${props.routeName}destroy`, props.technology_level.id));
        }
    });
};
</script>

<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm :title="`${routeName}edit`">
            <div class="grid grid-cols-1 md:grid-cols-2 space-x-2 mb-6 md:mb-0">
                <FormField label="Nivel de la Preparación:" required
                    help="Reasigna un nivel para la preparación tecnológica" :error="form.errors.level">
                    <FormControl v-model="form.level" placeholder="Reasigna un nivel" />
                </FormField>

                <FormField label="Nombre de la Preparación:" required
                    help="Reasigna un nombre para la preparación tencnológica" :error="form.errors.name">
                    <FormControl v-model="form.name" placeholder="Reasigna una nombre" />
                </FormField>

            </div>
            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="form.processing" />

                    <BaseButton @click="deleteForm" :icon="mdiTrashCan" color="danger" label="Eliminar"
                        :processing="form.processing" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>