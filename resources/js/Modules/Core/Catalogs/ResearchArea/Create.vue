<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>
        <CardBox>
            <DataForm :form="form" />

            <template #footer>
                <BaseButtons>
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="storeForm" :icon="mdiCheck" color="success" label="Guardar"
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
import DataForm from "./DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";
import { useLoading } from "@/Hooks/useLoading";
import { error422 } from "@/Hooks/useErrorsForm";


const props = defineProps({
    title: {
        type: String,
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
});

const form = useForm({
    name: '',
    description: '',
    order: '',
});

const { setLoading } = useLoading();

const storeForm = () => {
    form.post(route(`${props.routeName}store`), {
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
</script>