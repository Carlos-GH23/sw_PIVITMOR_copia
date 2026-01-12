<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPencil" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox>
            <div class="grid grid-cols-1 md:grid-cols space-x-2 mb-6 md:mb-0">
                <FormField label="Pregunta:" required :error="form.errors.question">
                    <FormControl v-model="form.question" placeholder="Pregunta frecuente" />
                </FormField>

                <FormField label="Respuesta:" required :error="form.errors.answer">
                    <FormControl v-model="form.answer" placeholder="Respuesta" type="textarea" height="h-32" class="w-full" maxLength="2000"/>
                </FormField>
            </div>

            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar" />
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

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    faq: {
        type: Object,
        required: true
    }
});

const form = useForm({
    question: props.faq.question,
    answer: props.faq.answer,
});

function saveForm() {
    form.put(route(`${props.routeName}update`, props.faq.id), {
        onSuccess: () => form.reset(),
    });
}
</script>
