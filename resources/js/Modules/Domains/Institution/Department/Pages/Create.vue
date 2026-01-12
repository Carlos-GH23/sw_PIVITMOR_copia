<template>
    <HeadLogo :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main :route-back="`${routeName}index`">
            <div class="md:block hidden">
                <BaseButton :icon="mdiClose" color="lightDark" :route-name="`${routeName}index`" />
            </div>
        </SectionTitleLineWithButton>

        <CardBox isForm class="mb-6">
            <DataForm :form="form" :errors="form.errors" />
        </CardBox>
        <CardBox>
                <div class="flex gap-2">
                    <BaseButton :routeName="`${routeName}index`" :icon="mdiClose" color="lightDark" label="Cancelar" />
                    <BaseButton @click="saveForm" :icon="mdiCheck" color="success" label="Guardar"
                        :processing="form.processing" />
                </div>
        </CardBox>
    </LayoutMain>
</template>

<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiPlus, mdiClose, mdiCheck } from "@mdi/js";
import BaseButton from "@/Components/BaseButton.vue";
import { useForm } from "@inertiajs/vue3";
import DataForm from "../Components/DataForm.vue";
import HeadLogo from "@/Components/HeadLogo.vue";

const props = defineProps({
    title: { type: String, default: "Crear Estructura Organizacional" },
    routeName: { type: String, default: "departments." },
});

const form = useForm({
    name: "",
    description: "",
});

const saveForm = () => {
    form.post(route(`${props.routeName}store`), { preserveScroll: true });
};
</script>
