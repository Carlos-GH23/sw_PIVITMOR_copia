<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm>
            <div class="grid grid-cols-1 md:grid-cols-2 space-x-2 mb-6 md:mb-0">
                <FormField label="Nombre del área de conocimiento:" required help="Nombre del área de conocimiento"
                    :error="form.errors.name">
                    <FormControl v-model="form.name" placeholder="Nombre del área de conocimiento" />
                </FormField>

                <FormField label="Área de conocimiento principal:"
                    help="Seleccione el área de conocimiento principal (opcional)" :error="form.errors.parent_id">
                    <FormControl v-model="form.parent_id" :options="parentAreas" class="w-full" />
                </FormField>
            </div>

            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="form.processing" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiCheck } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import { useForm } from "@inertiajs/vue3";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import HeadLogo from "@/Components/HeadLogo.vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    parentAreas: {
        type: Array,
        default: () => []
    }
});

const form = useForm({
    name: null,
    parent_id: null,
});

const saveForm = () => {
    form.post(route(`${props.routeName}store`));
};
</script>